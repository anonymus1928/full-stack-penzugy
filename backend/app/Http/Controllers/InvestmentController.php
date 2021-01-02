<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    /**
     * Get every investment made by the user.
     */
    public function getInvestment(Request $request) {
        $investments = Auth::user()->investments->all();
        return response()->json(['status' => 'OK', 'investments' => $investments], 200);
    }

    /**
     * Get investment by id.
     */
    public function getInvestmentById(Request $request, $id) {
        $investment = Auth::user()->investments->find($id);
        if(isset($investment)) {
            return response()->json(['status' => 'OK', 'investment' => $investment], 200);
        } else {
            return response()->json(['status' => 'error', 'error' => 'Investment not found'], 404);
        }
    }

    /**
     * Get investments by symbol.
     */
    public function getInvestmentBySymbol(Request $request, $symbol) {
        $share = Share::where('symbol', '=', $symbol)->first();
        if(!isset($share)) {
            return response()->json(['status' => 'error', 'error' => 'Symbol not found'], 404);
        }
        $investments = Auth::user()->investments->where('share_id', '=', $share['id']);
        if($investments->count() > 0) {
            return response()->json(['status' => 'OK', 'investments' => $investments], 200);
        } else {
            return response()->json(['status' => 'error', 'error' => 'No investment found with this symbol', 'symbol' => $symbol], 404);
        }
    }

    /**
     * Create investment.
     */
    public function createInvestment(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'symbol' => 'required',
            'price'  => 'required|numeric',
            'amount' => 'required|integer',
            'date'   => 'required|date'
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()], 422);
        }

        // Change apiKey for tests
        $test = isset($request->test);

        // Create or update share database entity
        $share = $this->storeShareFromAlpha($request->symbol, $test);

        // Error handling
        if(is_int($share)) {
            if(-1 == $share) {
                return response()->json(['status' => 'error', 'error' => 'Symbol not found'], 404);
            }
            if(-2 == $share) {
                return response()->json(['status' => 'error', 'error' => 'Limit exceeded, please try again later'], 429);
            }
        }

        $investment = new Investment;
        $investment->price = $request->price;
        $investment->amount = $request->amount;
        $investment->date = $request->date;
        $investment->share()->associate($share);
        $investment->getUser()->associate(Auth::user());
        $investment->save();
        return response()->json(['status' => 'OK', 'investment' => $investment], 201);
    }

    /**
     * Modify investment.
     */
    public function updateInvestment(Request $request, $id) {
        // Validation
        $validator = Validator::make($request->all(), [
            'price'  => 'numeric',
            'amount' => 'integer',
            'date'   => 'date'
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()], 422);
        }

        // Update investment
        $investment = Auth::user()->investments->where('id', '=', $id)->first();
        if(isset($investment)) {
            // Change apiKey for tests
            $test = isset($request->test);

            // Create or update share database entity
            $this->storeShareFromAlpha($investment->share->symbol, $test);

            $investment->update($request->all());
            return response()->json(['status' => 'OK'], 200);
        }
        return response()->json(['status' => 'error', 'error' => 'Id not found'], 404);
    }

    /**
     * Delete an investment (soft delete)
     */
    public function deleteInvestment(Request $request, $id) {
        $investment = Auth::user()->investments->find($id);
        if(isset($investment)) {
            $investment->delete();
            return response()->json(['status' => 'OK'], 200);
        }
        return response()->json(['status' => 'error', 'error' => 'Id not found'], 404);
    }

    /**
     * Helper functions
     */

    /**
     * Checks that the first date is one day earlier than the second one.
     * 
     */
    public function oneDayEarlier($datetime) {
        return abs(time() - strtotime($datetime)) < 60*60*24;
    }

    /**
     * Gets the given share via Alpha API.
     * If it exists in shares table updates it, otherwise creates it.
     */
    public function storeShareFromAlpha($symbol, $test = false) {
        $apiKey = env('ALPHA_API_KEY');
        if($test) {
            $apiKey = env('ALPHA_API_KEY_REAL');
        }
        $tmp = Share::where('symbol', '=', $symbol)->first();
        $company = [];
        if(!isset($tmp)) {
            // New entity
            $company = Http::get('https://www.alphavantage.co/query', [
                'function' => 'OVERVIEW',
                'symbol'   => $symbol,
                'apikey'   => $apiKey,
            ])->getBody();
            $company = json_decode($company);
            //dump($company, $symbol, $apiKey, env('ALPHA_API_KEY_REAL'), env('ALPHA_API_KEY'));
            
            // Wrong symbol
            if(!isset($company->Symbol)) {
                return -1;
            }
        } else {
            // Check last update time, return if it is less than 24 hour
            if($this->oneDayEarlier($tmp->updated_at)) {
                return $tmp;
            }
        }
        // Update database entity
        $daily = Http::get('https://www.alphavantage.co/query', [
            'function' => 'TIME_SERIES_DAILY',
            'symbol'   => $symbol,
            'apikey'   => $apiKey,
        ])->getBody();
        $daily = json_decode($daily);

        //return response()->json(['company' => $company, 'daliy' => $daily], 200);

        // Too much API call
        if(isset($company->{'Note'}) || isset($daily->{'Note'})) {
            log(json_encode($company));
            return -2;
        }

        $share = new Share;

        // Parse response
        if(!isset($tmp)) {
            // New entity
            $share->symbol                = $symbol;
            $share->name                  = $company->Name;
            $share->description           = $company->Description;
            $share->exchange              = $company->Exchange;
            $share->currency              = $company->Currency;
            $share->country               = $company->Country;
            $share->sector                = $company->Sector;
            $share->industry              = $company->Industry;
            $share->address               = $company->Address;
            $share->full_time_employees   = $company->FullTimeEmployees;
            $share->market_capitalization = $company->MarketCapitalization;
        }

        // History
        $history = array();
        $count = 0;
        foreach($daily->{'Time Series (Daily)'} as $date => $values) {
            $count++;
            $history[] = [
                'date'  => $date,
                'open'  => $values->{'1. open'},
                'high'  => $values->{'2. high'},
                'low'   => $values->{'3. low'},
                'close' => $values->{'4. close'},
            ];
            if(30 == $count) {
                break;
            }
        }
        $share->history = json_encode($history);

        // Store entity
        $share->save();
        return $share;
    }
}

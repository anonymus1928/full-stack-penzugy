<?php

namespace App\Http\Controllers;

use App\Models\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Get share by symbol.
     * Without symbol returns every shares.
     */
    public function getShare(Request $request, $symbol = null) {
        $share = null;
        if(isset($symbol)) {
            $share = Share::where('symbol', '=', $symbol)->first();
        } else {
            $share = Share::all();
        }
        if(isset($share)) {
            return response()->json(['status' => 'OK', 'share' => $share], 200);
        }
        return response()->json(['status' => 'error', 'error' => 'Symbol not found'], 404);
    }

    /**
     * Create or update a share.
     */
    public function createOrUpdateShare(Request $request, $symbol) {
        // Get helper functions
        $helper = new InvestmentController;

        // Change apiKey for tests
        $test = isset($request->test);
        
        $share = $helper->storeShareFromAlpha($symbol, $test);

        // Error handling
        if(is_int($share)) {
            if(-1 == $share) {
                return response()->json(['status' => 'error', 'error' => 'Symbol not found', 'test' => $test], 404);
            }
            if(-2 == $share) {
                return response()->json(['status' => 'error', 'error' => 'Limit exceeded, please try again later'], 429);
            }
        }

        return response()->json(['status' => 'OK', 'share' => $share]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller {
    
    /**
     * Get every transaction if $id is null, otherwise get
     * the transaction with the id.
     */
    public function getTransaction(Request $request, $id = null) {
        $transaction = null;
        if(isset($id)) {
            $transaction = Transaction::with('categories')->where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->first();
            if(!isset($transaction)) {
                return response()->json(['status' => 'error', 'error' => 'Transaction not found'], 404);
            }
            return response()->json(['status' => 'OK', 'transaction' => $transaction], 200);
        }

        $transaction = Transaction::with('categories')->where('user_id', '=', Auth::user()->id)->get();
        return response()->json(['status' => 'OK', 'transaction' => $transaction], 200);
    }


    /**
     * Create a new transaction
     */
    public function createTransaction(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'name' => 'required',
            'due' => 'required|date',
            'categories' => 'nullable|array',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()], 422);
        }

        $transaction = new Transaction;
        $transaction->amount = $request->amount;
        $transaction->name = $request->name;
        $transaction->description = $request->description;
        $transaction->due = $request->due;
        $transaction->getUser()->associate(Auth::user());
        $transaction->save();
        $transaction->categories()->attach($request->categories);

        return response()->json(['status' => 'OK', 'transaction' => $transaction], 201);
    }


    /**
     * Modify a transaction.
     */
    public function modifyTransaction(Request $request, $id) {
        // Validation
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'name' => 'required',
            'due' => 'required|date',
            'categories' => 'nullable|array',
        ]);
        if($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors()], 422);
        }
        $transaction = Auth::user()->transactions->find($id);
        if(!isset($transaction)) {
            return response()->json(['status' => 'error', 'error' => 'Transaction not found'], 404);
        }
        $transaction->update($request->all());
        return response()->json(['status' => 'OK', 'transaction' => $transaction], 200);
    }


    /**
     * Add category to a transaction.
     */
    public function addCategoryToTransaction(Request $request, $id, $ct) {
        $transaction = Auth::user()->transactions->find($id);
        if(!isset($transaction)) {
            return response()->json(['status' => 'error', 'error' => 'Transaction not found'], 404);
        }
        $category = Auth::user()->categories->find($ct);
        if(!isset($category)) {
            return response()->json(['status' => 'error', 'error' => 'Category not found'], 404);
        }

        // Check if category already attached to the transaction.
        if(in_array($ct, $transaction->categories->pluck('id')->toArray())) {
            return response()->json(['status' => 'error', 'error' => 'Category already attached to the transaction'], 404);
        }

        $transaction->categories()->attach($ct);
        return response()->json(['status' => 'OK']);
    }


    /**
     * Remove category from a transaction.
     */
    public function removeCategoryFromTransaction(Request $request, $id, $ct = null) {
        $transaction = Auth::user()->transactions->find($id);
        if(!isset($transaction)) {
            return response()->json(['status' => 'error', 'error' => 'Transaction not found'], 404);
        }
        $category = null;
        if(isset($ct)) {
            $category = Auth::user()->categories->find($ct);
            if(!isset($category)) {
                return response()->json(['status' => 'error', 'error' => 'Category not found'], 404);
            }
        }

        if(isset($category)) {
            $transaction->categories()->detach($ct);
        } else {
            $transaction->categories()->detach($transaction->categories->pluck('id')->toArray());
        }
        
        return response()->json(['status' => 'OK']);
    }
}

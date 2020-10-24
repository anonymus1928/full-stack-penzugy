<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller {
    
    /**
     * Get every transaction if $id is null, otherwise get
     * the transaction with the id.
     */
    public function getTransaction(Request $request, $id = null) {
        if(isset($id)) {
            return Auth::user()->transactions->where('id', '=', $id);
        } else {
            return Auth::user()->transactions;
        }
    }
}

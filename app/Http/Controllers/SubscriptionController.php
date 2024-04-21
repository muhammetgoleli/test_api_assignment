<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Device;
use App\DataTables\UsersDataTable;

class SubscriptionController extends Controller
{

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('subscription.index');
    }

    public function store(Request $request) {

        $request->validate([
            'userId'       => 'required|integer',
            'productId'    => 'required|string',
            'receiptToken' => 'required|string'
        ]);

        if (!$this->validateToken($request->receiptToken)) {
            return response()->json(['error' => 'Invalid receipt token'], 400);
        }
        
        $result = $this->processSubscription($request['userId']);

        return response()->json([
            'status' => $result->subscription_status
        ]);
    }

    private function validateToken($receiptToken) {
        $purchase = Purchase::where('receipt_token', $receiptToken)->first();

        return (bool) $purchase;
    }

    private function processSubscription($userId) {

        $user = User::find($userId);
        $user->subscription_status = 'premium';
        $user->chat_credit =  100;
        $user->save();

        return $user;
    }
}

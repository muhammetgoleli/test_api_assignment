<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function authenticate(Request $request) {
        $request->validate([
            'userId'       => 'required|integer',
            'device_uuid'  => 'required|string',
            'device_name'  => 'required|string'
        ]);

        $user = User::where('user_id', $request->userId)->first();

        if (! $user || ! Hash::check($request->device_uuid)) {
            throw ValidationException::withMessages([
                'device_uuid' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        $device = Device::where('device_uuid', $request)->first();

        if(!$device) {
            $device = Device::firstOrCreate(
                ['user_id'            => $request->userId, 
                'device_uuid'         => $request->device_uuid,
                'device_name'         => $request->device_name, 
                'subscription_status' => 'free'
            ]);
        }

        $config = [
            'user_id'     => $request->userId,
            'device_uuid' => $request->device_uuid,
            'device_name' => $request->device_name,
            'chat_credit' => $request->chat_credit
        ];

        return response()->json([
            'subscription_status' => $user->subscription_status,
            'configuration'       => $config,
            'receiptToken'        => $user->createToken($request->device_name)->plainTextToken
        ]);
    }
}


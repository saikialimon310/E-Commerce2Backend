<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Validator;

class UserInformationController extends Controller
{
    // ✅ Store Address
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_line' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|string',
            'country' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $address = UserInformation::create([
            'user_id' => $request->user()->id,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'country' => $request->country,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'message' => 'Address added successfully',
            'data' => $address
        ], 201);
    }

    // ✅ Get All Addresses (for logged-in user)
    public function index(Request $request)
    {
        $addresses = UserInformation::where('user_id', $request->user()->id)->get();

        return response()->json($addresses);
    }

    // ✅ Update Address
    public function update(Request $request, $id)
    {
        $address = UserInformation::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->update($request->all());

        return response()->json([
            'message' => 'Address updated successfully',
            'data' => $address
        ]);
    }

    // ✅ Delete Address
    public function destroy(Request $request, $id)
    {
        $address = UserInformation::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();

        return response()->json([
            'message' => 'Address deleted successfully'
        ]);
    }
}

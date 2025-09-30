<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Broker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $brokers = Broker::all();

        return response()->json([
            $brokers
        ]);
    }

    /**
     * Display the specified resource by slug.
     */
    public function show(Broker $broker): JsonResponse
    {
        return response()->json([
            $broker
        ]);
    }
}

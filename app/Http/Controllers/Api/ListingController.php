<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $listings = Listing::all();

        return response()->json([
            $listings
        ]);
    }

    /**
     * Display the specified resource by slug.
     */
    public function show(Listing $listing): JsonResponse
    {
        return response()->json([
            $listing
        ]);
    }
}

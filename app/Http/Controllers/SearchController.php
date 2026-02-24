<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Original search implementation (temporarily simplified for Scout debug).
     *
     * public function search(Request $request)
     * {
     *     $query = $request->input('query');
     *
     *     $results = Product::search($query)->raw();
     *
     *     return response()->json([
     *         'query' => $query,
     *         'scout_raw_results' => $results,
     *     ]);
     * }
     */
    public function search(Request $request)
    {
        $query = $request->input('query') ?? $request->input('q') ?? $request->input('search');

        $results = Product::search($query)->raw();

        return response()->json([
            'controller' => __CLASS__,
            'method' => __FUNCTION__,
            'query' => $query,
            'scout_raw_results' => $results,
        ]);
    }
}

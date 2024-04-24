<?php

namespace App\Http\Controllers\Api\City;

use App\Http\Controllers\Controller;
use App\Models\City;

class CityHomeController extends Controller
{
    /**
     * @OA\Put(
     *     path="/api/City/All",
     *     summary="All City",
     *     tags={"City Home"},
     *     @OA\Response(response="200", description="User update successfully"),
     * )
     */
    public function index()
    {
        return City::all();
    }
}

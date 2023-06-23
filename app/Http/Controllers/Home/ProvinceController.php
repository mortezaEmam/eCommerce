<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function getCities(Request $request)
    {
        $data['cities'] = City::query()->where("province_id", $request->province_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }
}

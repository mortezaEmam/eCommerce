<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Banner::query()->where('type','slider')->where('is_active',1)->orderBy('priority')->get();
        $index_top_banners = Banner::query()->where('type','index_top')->where('is_active',1)->orderBy('priority')->get();
        $index_botton_banners = Banner::query()->where('type','index_bottom')->where('is_active',1)->orderBy('priority')->get();
        return view('home.index',compact('sliders','index_top_banners','index_botton_banners'));
    }
}

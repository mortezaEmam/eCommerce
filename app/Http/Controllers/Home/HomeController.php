<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\ContactUs;
use App\Models\Setting;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        $sliders = Banner::query()->where('type', 'slider')->where('is_active', 1)->orderBy('priority')->get();
        $index_top_banners = Banner::query()->where('type', 'index_top')->where('is_active', 1)->orderBy('priority')->get();
        $index_botton_banners = Banner::query()->where('type', 'index_bottom')->where('is_active', 1)->orderBy('priority')->get();
        return view('home.index', compact('sliders', 'index_top_banners', 'index_botton_banners'));
    }

    function aboutUs()
    {
        $index_botton_banners = Banner::query()->where('type', 'index_bottom')->where('is_active', 1)->orderBy('priority')->get();
        return view('home.about-us', compact('index_botton_banners'));
    }

    function contactUs()
    {
        $setting = Setting::findOrFail(1);
        $data = [
            'setting' => $setting,
            'user' => Auth::user(),
        ];
        return view('home.contact-us', $data);
    }

    function contactUsForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:50',
            'email' => 'required|email',
            'subject' => 'required|string|min:4|max:100',
            'text' => 'required|string|min:4|max:3000',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'text' => $request->text
        ]);

        alert()->success('پیام شما با موفقیت ثبت شد', 'با تشکر');
        return redirect()->back();
    }
}

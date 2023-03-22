<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::query()->latest()->paginate(10);
        return view('admin.banners.index-banner', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create-banner');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,svg,png',
            'type' => 'required',
            'priority' => 'integer',
        ]);
        $image = upload_Primary_image_product($request->image, env('PRODUCT_BANNER_IMAGES_UPLOAD_PATH'));
        $banner = new Banner();
        $banner->image = $image;
        $banner->title = $request->title;
        $banner->text = $request->text;
        $banner->priority = $request->priority;
        $banner->is_active = $request->is_active;
        $banner->type = $request->type;
        $banner->button_text = $request->button_text;
        $banner->button_link = $request->button_link;
        $banner->button_icon = $request->button_icon;
        $banner->save();
        alert()->success('بنر مورد نظر ایجاد شد', 'باتشکر');
        return redirect()->route('admin.banners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit-banner', compact('banner'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|mimes:jpg,jpeg,svg,png',
            'type' => 'required',
            'priority' => 'integer',
        ]);
        if (filled($request->image)) {
            $image = upload_Primary_image_product($request->image, env('PRODUCT_BANNER_IMAGES_UPLOAD_PATH'));
        }

        $banner->update([
            'image' => $request->has('image') ? $image : $banner->image,
            'title' => $request->title,
            'text' => $request->text,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon,
        ]);
        alert()->success('بنر مورد نظر ویرایش شد', 'باتشکر');
        return redirect()->route('admin.banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        alert()->success('بنر مورد نظر حذف شد', 'باتشکر');
        return redirect()->route('admin.banners.index');
    }
}

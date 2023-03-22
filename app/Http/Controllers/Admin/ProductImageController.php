<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteImageRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{

    public function edit(Product $product)
    {
        return view('admin.products.edit-image-product', compact('product'));
    }

    public function destroy(DeleteImageRequest $request, Product $product)
    {
        $product->files()->where('id', $request->image_id)->delete();
        alert()->success('تصویر محصول مورد نظر حدف شد', 'باتشکر');
        return redirect()->back();
    }

    public function setPrimary(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:files,id'
        ]);

        $productImage = $product->files()->where('id', $request->image_id)->first();
        $product->update([
            'primary_image' => $productImage->path . '/' . $productImage->name,
        ]);
        alert()->success('ویرایش تصویر اصلی محصول با موفقیت انجام شد', 'باتشکر');
        return redirect()->back();

    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'primary_image' => 'nullable|mimes:jpg,jpeg,png,svg',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,svg',
        ]);

        if ($request->primary_image == null && $request->images == null) {
            return redirect()->back()->withErrors(['massage' => 'تصویر یا تصاویر محصول الزامی هست']);
        }

        try {
            DB::beginTransaction();
            //update  primary image
            if ($request->has('primary_image')) {

                $primary_image = upload_Primary_image_product($request->primary_image, env('PRODUCT_PRIMARY_IMAGES_UPLOAD_PATH'));

                $product->update([
                    'primary_image' => $primary_image
                ]);
            }
                // add images of product in the file tabel
                if (filled($request->images)) {
                    foreach ($request->images as $image) {
                        uploadFile($product, $image, env('PRODUCT_IMAGES_UPLOAD_PATH'));
                    }
                }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد محصول', $ex->getMessage())->persistent('حله');
            return redirect()->back();
        }

        alert()->success('ویرایش تصویر اصلی محصول با موفقیت انجام شد', 'باتشکر');
        return redirect()->back();
    }
}

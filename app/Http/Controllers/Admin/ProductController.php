<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\uploader_image;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use uploader_image;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query()->latest()->paginate(20);
        return view('admin.products.index-product',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $tags = Tag::all();
        $categories = Category::query()->where('parent_id', '!=', 0)->get();

        return view('admin.products.create-product', compact('brands', 'tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            //upload primary_image for product
            if (filled($request->primary_image)) {
                $primary_image = $this->upload($request->primary_image, $this->address_upload_image(true),null);

            }
            //store data into product table
            $product = Product::query()->create([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'primary_image' => filled($primary_image) ? $primary_image : null,
                'description' => $request->description,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,
                'is_active' => $request->is_active,
            ]);

            //upload && store images for product into file table
            foreach ($request->images as $image) {
                $this->upload($image, $this->address_upload_image(false,true), $product);
            }

            //insert data into product_attributes table
            ProductAttribute::StoreProductAttributes($request->attribute_ids, $product);

            //insert data into product_variations table
            $category = Category::query()->find($request->category_id);
            $attribute_id = $category->attributes()->wherePivot('is_variation', 1)->first()->id;

            for ($i = 0; $i < count($request->attribute_variation['value']); $i++) {
                ProductVariation::StoreProductVariation($request->attribute_variation, $attribute_id, $product, $i);
            }

            //store tages for product

            $product->tags()->attach($request->tag_ids);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد محصول', $ex->getMessage());
            return redirect()->back();
        }

        alert()->success('محصول مورد نظر ایجاد شد', 'باتشکر');
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = [
            'product' => $product,
            'productAttributes' => $product->attributes()->with('attribute')->get(),
            'images' => $product->files,
            'productVariations' => $product->variations,
        ];
        return view('admin.products.show-product', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = [
            'product' => $product,
            'brands' => Brand::all(),
            'productTagIds' => $product->tags()->pluck('id')->toArray(),
            'tags' => Tag::all(),
            'productAttributes' => $product->attributes()->with('attribute')->get(),
            'productVariations' => $product->variations,
        ];
        return view('admin.products.edit-product', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

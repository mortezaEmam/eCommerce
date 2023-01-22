<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::query()->where('parent_id', 0)->get();
        $attributes = Attribute::all();

        return view('admin.categories.create', compact('parentCategories', 'attributes'));
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
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories,slug|max:255',
            'parent_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_is_filter_ids' => 'required',
            'variation_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $category = Category::query()->create([
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'icon' => $request->icon,
            ]);

            foreach ($request->attribute_ids as $attribute_id) {
                $attribute = Attribute::query()->findOrFail($attribute_id);
                $attribute->categories()->attach($category->id, [
                    'is_filter' => in_array($attribute_id, $request->attribute_is_filter_ids) ? 1 : 0,
                    'is_variation' => $request->variation_id == $attribute_id ? 1 : 0,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->success('خطا', $e->getMessage());
            return redirect()->back();
        }
        alert()->success('با تشکر', 'دسته بندی مورد نظر شما با موفقیت ایجاد شد');
        return redirect()->route('admin.categories.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

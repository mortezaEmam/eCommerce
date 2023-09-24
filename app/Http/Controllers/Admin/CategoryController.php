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

    public function index()
    {
        $categories = Category::query()->latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        $parentCategories = Category::query()->where('parent_id', 0)->get();
        $attributes = Attribute::all();

        return view('admin.categories.create', compact('parentCategories', 'attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'parent_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'exists:attributes,id',
            'attribute_is_filter_ids' => 'required',
            'attribute_is_filter_ids.*' => 'exists:attributes,id',
            'variation_id' => 'required|exists:attributes,id',
        ]);
        try {
            DB::beginTransaction();
            $category = Category::query()->create([
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'icon' => $request->icon,
                'is_active' =>$request->is_active,
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

    public function show(Category $category)
    {
        return view('admin.categories.show',compact('category'));
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::query()->where('parent_id', 0)->get();
        $attributes = Attribute::all();
        return view('admin.categories.edit',compact('category','parentCategories','attributes'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id,
            'parent_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'exists:attributes,id',
            'attribute_is_filter_ids' => 'required',
            'attribute_is_filter_ids.*' => 'exists:attributes,id',
            'variation_id' => 'required|exists:attributes,id',
        ]);

        try {
            DB::beginTransaction();

            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'icon' => $request->icon,
                'description' => $request->description,
                'is_active' =>$request->is_active,
            ]);

            $category->attributes()->detach();

            foreach ($request->attribute_ids as $attributeId) {
                $attribute = Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id, [
                    'is_filter' => in_array($attributeId, $request->attribute_is_filter_ids) ? 1 : 0,
                    'is_variation' => $request->variation_id == $attributeId ? 1 : 0
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش دسته بندی', $ex->getMessage());
            return redirect()->back();
        }

        alert()->success('دسته بندی مورد نظر ویرایش شد', 'باتشکر');
        return redirect()->route('admin.categories.index');
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

    public function getCategoryAttributes(Category $category)
    {
        $attributes = $category->attributes()->wherePivot('is_variation' ,0)->get();
        $variation = $category->attributes()->wherePivot('is_variation' ,1)->first();
        return ['attrubtes' => $attributes , 'variation' => $variation];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال' :'غیرفعال';
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function childern()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class,'attribute_category')  ;
    }
    public static function getParentCategory()
    {
        return static::query()->where('parent_id',0)->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

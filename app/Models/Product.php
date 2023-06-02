<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'products';
    protected $guarded = [];
    protected $appends = ['quantity_check', 'sale_check', 'price_check'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال' : 'غیرفعال';
    }

    public function getQuantityCheckAttribute()
    {
        return $this->variations()->where('quantity', '>', 0)->first() ?? 0;
    }

    public function getPriceCheckAttribute()
    {
        return $this->variations()->where('quantity', '>', 0)->orderBy('price')->first() ?? false;
    }

    public function getSaleCheckAttribute()
    {
        return $this->variations()->where('quantity', '>', 0)
            ->where('sale_price', '!=', null)->where('date_on_sale_from', '<', Carbon::now())
            ->where('date_on_sale_to', '>', Carbon::now())->orderBy('sale_price')->first() ?? false;
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class,);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public static function getAllProducts()
    {
        return static::query()->where('is_active', 1)->get();
    }

    public function rates()
    {
        return $this->hasMany(ProductRates::class);
    }

    public function scopeFilter($query)
    {
        if (request()->has('attribute')) {
            foreach (request()->attribute as $attribute) {
                $query->whereHas('attributes', function ($query) use ($attribute) {
                    foreach (explode('-', $attribute) as $index => $item) {
                        if ($index == 0) {
                            $query->where('value', $item);
                        } else {
                            $query->orwhere('value', $item);
                        }
                    }
                });
            }
        }
        if (request()->has('variation')) {
            $query->whereHas('variations', function ($query) {
                foreach (explode('-', request()->variation) as $index => $variation) {
                    if ($index == 0) {
                        $query->where('value', $variation);
                    } else {
                        $query->orwhere('value', $variation);
                    }
                }
            });

        }
        if (request()->has('sortBy')) {
            $sort = request()->sortBy;
            switch ($sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'min':
                    $query->orderBy(ProductVariation::select('price')->whereColumn('product_variations.product_id', 'products.id')->orderBy('sale_price', 'desc')->take(1));
                    break;
                case 'max':
                    $query->orderByDesc(ProductVariation::select('price')->whereColumn('product_variations.product_id', 'products.id')->orderBy('sale_price', 'desc')->take(1));
                    break;
                default:
                    $query;
                    break;
            }
        }
//       dd($query->toSql());
        return $query;
    }

    public function scopeSearch($query)
    {
        $KeyWord = request()->search;
        if (request()->has('search') && trim($KeyWord) != '') {
            $query->where('name', 'LIKE', '%' . trim($KeyWord) . '%');
        }
        return $query;
    }

    public function approvedComment()
    {
        return $this->hasMany(Comment::class)->where('approved',1);
    }
    public function avgProductRateOfUser(User $user)
    {
        return $this->rates()->where('user_id',$user->id)->avg('rate');
    }
}

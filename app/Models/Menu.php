<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['vendor_id', 'name', 'description', 'background_image', 'status'];

    protected $with = ['categories'];

    public $appends = ['category_name', 'product_names', 'product_prices', 'product_sizes'];

    protected function getCategoryNameAttribute()
    {
        $categoryNames = [];
        if ($this->categories()->count() > 0) {
            foreach ($this->categories()->get() as $category) {
                $categoryNames[] = $category->name;
            }
        }
        if (count($categoryNames) > 0) {
            return implode(',', $categoryNames);
        }

        return null;
    }

    protected function getProductNamesAttribute()
    {
        $productNames = [];
        if ($this->categories()->count() > 0) {
            foreach ($this->categories()->get() as $category) {
                foreach ($category->products as $product) {
                    $productNames[] = $product->name;
                }
            }
        }
        if (count($productNames) > 0) {
            return implode(',', $productNames);
        }

        return null;
    }

    protected function getProductPricesAttribute()
    {
        $prices = [];
        if ($this->categories()->count() > 0) {
            foreach ($this->categories()->get() as $category) {
                foreach ($category->products as $product) {
                    foreach ($product->details as $detail) {
                        $prices[] = $detail->price;
                    }
                }
            }
        }
        if (count($prices) > 0) {
            return implode(',', $prices);
        }

        return null;
    }

    protected function getProductSizesAttribute()
    {
        $quantities = [];
        if ($this->categories()->count() > 0) {
            foreach ($this->categories()->get() as $category) {
                foreach ($category->products as $product) {
                    foreach ($product->details as $detail) {
                        $quantities[] = $detail->quantity;
                    }
                }
            }
        }
        if (count($quantities) > 0) {
            return implode(',', $quantities);
        }

        return null;
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_menu', 'menu_id', 'category_id')->with('products.details');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }
}

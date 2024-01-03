<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['vendor_id', 'name', 'ingredients', 'status'];

    protected $with = ['categories', 'details'];

    protected $appends = ['prices', 'quantities', 'categories'];

    public function getPricesAttribute()
    {
        if($this->details()->exists()){
            return $this->details()->pluck('price')->toArray();
        }
        return null;
    }
    public function getQuantitiesAttribute()
    {
        if($this->details()->exists())
        {
            return $this->details()->pluck('quantity')->toArray();
        }
        return null;
    }

    public function getCategoriesAttribute(){
        if($this->categories()->exists()){
            return $this->categories()->pluck('name')->toArray();
        }
        return null;
    }

    protected function ingredients(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProductDetail::class);
    }
}

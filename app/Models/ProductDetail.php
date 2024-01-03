<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'price'];

    protected function quantity(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value == 1) {
                    return 'Small';
                }
                if ($value == 2) {
                    return 'Medium';
                }
                if ($value == 3) {
                    return 'Large';
                }

                return 'N/A';
            },
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

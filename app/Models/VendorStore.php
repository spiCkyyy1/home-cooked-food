<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorStore extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'description', 'address','longitude', 'latitude', 'number', 'post_code', 'status'];

    public function timings()
    {
        return $this->hasMany(VendorStoreTiming::class);
    }
}

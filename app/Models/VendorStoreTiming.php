<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorStoreTiming extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['vendor_store_id', 'weekday', 'start_hour', 'end_hour', 'status'];

    public function vendorStore()
    {
        return $this->belongsTo(VendorStore::class);
    }
}

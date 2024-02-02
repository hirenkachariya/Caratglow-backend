<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMetalDetail extends Model
{
    use HasFactory;
    protected $table = 'tbl_product_metal_detail';

    public function metal()
    {
        return $this->belongsTo(ProductMetal::class, 'MetalId', 'MetalId')->select('MetalId', 'MetalName');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $table = 'tbl_product_master';

    public function metalDetail()
    {
        return $this->belongsTo(ProductMetalDetail::class, 'MetalType', 'MetalDId')->select('MetalDId','Description');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMetal extends Model
{
    use HasFactory;
    protected $table = 'tbl_product_metal';

    public function metaldetail()
    {
        return $this->belongsTo(ProductMetalDetail::class, 'MetalId', 'MetalId')->select('MetalId', 'Description');
    }
}

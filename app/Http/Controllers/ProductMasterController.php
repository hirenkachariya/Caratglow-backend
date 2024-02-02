<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Response;

class ProductMasterController extends Controller
{
    public function product()
    {
        try {
            $products = CategoryProduct::all();
            $products = $products->map(function ($product) {
                $product['Image'] = 'https://www.kasturidiamond.com/public/product_images/KJPD0238.jpg';
                $product = $product->only([
                    'ProductId', 'ProductTitle', 'ProductDesc', 'Image'
                ]);
                return $product;
            });
            return new Response([
                "status" => true,
                "data" => $products,
            ]);
        } catch (\Throwable $th) {
            return new Response([
                "status" => false,
                "message" => $th->getMessage()
            ]);
        }
        
    }
}

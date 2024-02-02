<?php

namespace App\Http\Controllers;

use App\Models\ProductMetal;
use App\Models\ProductMetalDetail;
use Illuminate\Http\Response;

class MatelController extends Controller
{
    public function metal()
    {
        try {
            $datas = ProductMetalDetail::with('metal')->select('MetalId', 'MetalDId', 'Description')
                ->get();

            return new Response(
                $datas
            );
        } catch (\Throwable $th) {
            return new Response([
                "status" => false,
                "message" => $th->getMessage()
            ]);
        }
    }
}

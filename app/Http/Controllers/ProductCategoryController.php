<?php

namespace App\Http\Controllers;

use App\Models\Productcategory;
use Illuminate\Http\Response;

class ProductCategoryController extends Controller
{
    public function category()
    {
        try {
            $categories = Productcategory::select('CategoryId', 'CategoryName', 'ParentCategoryId')
                ->whereIn('CategoryId', [1, 2, 3, 4, 5])
                ->get();

            $result = [];

            foreach ($categories as $category) {
                $subcategories = Productcategory::select('CategoryId', 'CategoryName')
                    ->where('ParentCategoryId', $category->CategoryId)
                    ->get();

                if ($category->CategoryId == 1) {
                    $result[] = [
                        'ring' => [
                            'Id' => $category->CategoryId,
                            'name' => $category->CategoryName,
                            'sub' => $subcategories,
                        ],
                    ];
                } elseif ($category->CategoryId == 2) {
                    $result[] = [
                        'earring' => [
                            'Id' => $category->CategoryId,
                            'name' => $category->CategoryName,
                            'sub' => $subcategories,
                        ],
                    ];
                } elseif ($category->CategoryId == 3) {
                    $result[] = [
                        'pendant' => [
                            'Id' => $category->CategoryId,
                            'name' => $category->CategoryName,
                            'sub' => $subcategories,
                        ],
                    ];
                } elseif ($category->CategoryId == 4) {
                    $result[] = [
                        'tanmania' => [
                            'Id' => $category->CategoryId,
                            'name' => $category->CategoryName,
                            'sub' => $subcategories,
                        ],
                    ];
                } elseif ($category->CategoryId == 5) {
                    $result[] = [
                        'bangle' => [
                            'Id' => $category->CategoryId,
                            'name' => $category->CategoryName,
                            'sub' => $subcategories,
                        ],
                    ];
                }
            }

            return new Response([
                "status" => true,
                "data" => $result
            ]);
        } catch (\Throwable $th) {
            return new Response([
                "status" => false,
                "message" => $th->getMessage()
            ]);
        }
    }
}

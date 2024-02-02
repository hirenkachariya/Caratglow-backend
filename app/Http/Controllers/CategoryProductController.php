<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProductMetalDetail;


class CategoryProductController extends Controller
{
    public function categoryproduct(Request $request)
    {
        try {

            $perPage = 10;

            $param = $request->all();
            $weight = $request->WEI_GHT;

            $resultArray = [];
            if ($weight != '') {
                $resultArray = explode("-", $weight);
            }
            $minGrams = 0;
            $maxGrams = 0;
            if (count($resultArray) > 0) {
                $minGrams = $resultArray[0];
                $maxGrams = $resultArray[1];
            }

            $price = $request->PRI_CE;
            $resultArrays = [];
            if ($price != '') {
                $resultArrays = explode("-", $price);
            }

            $minPrices = 0;
            $maxPrices = 0;
            if (count($resultArrays) > 0) {
                $minPrices = $resultArrays[0];
                $maxPrices = $resultArrays[1];
            }

            $metalDetails = ProductMetalDetail::pluck('MetalDId', 'Description');
            $categoryproduct = CategoryProduct::where(function ($q) use ($param, $metalDetails, $minGrams, $maxGrams, $minPrices, $maxPrices) {
                if (isset($param['Metal_Type']) && count($param['Metal_Type']) > 0) {
                    $q->where(function ($qr) use ($param, $metalDetails) {
                        foreach ($param['Metal_Type'] as $value) {
                            $temp = str_replace("-", " ", $value);
                            $qr->orWhere('MetalType', $metalDetails[$temp]);
                        }
                    });
                }
                if (isset($param['MORE_FILTERS']) && count($param['MORE_FILTERS'])) {
                    $q->where(function ($qr) use ($param) {
                        foreach ($param['MORE_FILTERS'] as $value) {
                            $qr->orWhere('ProductTitle', $value);
                        }
                    });
                }
                if ($minGrams > 0 && $maxGrams > 0) {
                    $q->whereBetween('AppxMetalWgt', [$minGrams, $maxGrams]);
                } else if ($minGrams > 0 && $maxGrams == 0) {
                    $q->where('AppxMetalWgt', '<=', $minGrams);
                } else if ($minGrams == 0 && $maxGrams > 0) {
                    $q->where('AppxMetalWgt', '>=', $maxGrams);
                }
                if ($minPrices > 0 && $maxPrices > 0) {
                    $q->whereBetween('SettingPrice', [$minPrices, $maxPrices]);
                } elseif ($minPrices > 0 && $maxPrices == 0) {
                    $q->where('SettingPrice', '<=', $minPrices);
                } elseif ($minPrices == 0 && $maxPrices > 0) {
                    $q->where('SettingPrice', '>=', $maxPrices);
                }

                return $q;
            })->paginate($perPage);

            $filteredProducts = $categoryproduct->map(function ($product) {
                $product['Image'] = 'https://htmldemo.net/corano/corano/assets/img/product/product-5.jpg';

                $filteredProduct = $product->only([
                    'ProductId', 'ProductTitle', 'ProductDesc', 'Image', 'AppxMetalWgt', 'metalDetail', 'SettingPrice'
                ]);
                return $filteredProduct;
            });

            $currentPage = $categoryproduct->currentPage();
            $filteredProducts = $filteredProducts->map(function ($wishlist, $key) use ($perPage, $currentPage) {
                $key = ($currentPage - 1) * $perPage + $key + 1;
                return $wishlist + ['key' => $key];
            });

            $paginationDetails = [
                'total' => $categoryproduct->total(),
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => $categoryproduct->lastPage(),
                'from' => $categoryproduct->firstItem(),
                'to' => $categoryproduct->lastItem(),
            ];

            return new Response([
                "status" => true,
                "data" => $filteredProducts->toArray(),
                'pagination' => $paginationDetails,
            ]);
        } catch (\Throwable $th) {
            return new Response([
                "status" => false,
                "message" => $th->getMessage()
            ]);
        }
    }
    // Exception in error line give me

    public function categorylist()
    {
        try {
            $metalType = array(
                'Title' => 'METAL TYPE',
                'Value' => 'Metal_Type',
                "List" => array(
                    array(
                        'Img' => 'https://html.weingenious.in/cg-assets/uploads/parameter/157736185614.png',
                        'Title' => '14K White Gold',
                        'Value' => '14K-White-Gold'
                    ),
                    array(
                        'Img' => 'https://html.weingenious.in/cg-assets/uploads/parameter/157736184385.png',
                        'Title' => '14K Rose Gold',
                        'Value' => '14K-Rose-Gold'
                    ),
                    array(
                        'Img' => 'https://html.weingenious.in/cg-assets/uploads/parameter/157736193265.png',
                        'Title' => '14K Yellow Gold',
                        'Value' => '14K-Yellow-Gold'
                    ),
                    array(
                        'Img' => 'https://html.weingenious.in/cg-assets/uploads/parameter/157736185642.png',
                        'Title' => '18K White Gold',
                        'Value' => '18K-White-Gold'
                    ),
                    array(
                        'Img' => 'https://html.weingenious.in/cg-assets/uploads/parameter/157736184320.png',
                        'Title' => '18K Rose Gold',
                        'Value' => '18K-Rose-Gold'
                    ),
                    array(
                        'Img' => 'https://html.weingenious.in/cg-assets/uploads/parameter/157736193382.png',
                        'Title' => '18K Yellow Gold',
                        'Value' => '18K-Yellow-Gold'
                    ),
                )
            );
            $diamond = array(
                "Title" => 'DIAMONDS',
                'Value' => 'Diamonds',
                "List" => array(
                    array(
                        'Img' => 'https://html.weingenious.in/cg-assets/uploads/shape/157198326153.png',
                        'Title' => 'Round',
                        'Value' => 'Round'
                    )
                )
            );
            $weight = array(
                'Title' => 'WEIGHT',
                'Value' => 'WEI_GHT',
                'List' => array(
                    array(
                        'Title' => 'WEIGHT',
                        'Value' => '0-0'
                    ),
                    array(
                        'Title' => 'Less Than 2 Grams',
                        'Value' => '2-0'
                    ),
                    array(
                        'Title' => '2 Grams 10 Grams',
                        'Value' => '2-10',
                    ),
                    array(
                        'Title' => '18 Grams 26 Grams',
                        'Value' => '18-26',
                    ),
                    array(
                        'Title' => '26 Grams And Above',
                        'Value' => '0-26',
                    ),
                )
            );
            $settingtype = array(
                'Title' => 'SETTING TYPE',
                'List' => array(
                    array(
                        'Title' => 'Prong',
                    ),
                    array(
                        'Title' => 'Channel',
                    ),
                    array(
                        'Title' => 'Micro pave',
                    ),
                    array(
                        'Title' => 'Bazel',
                    ),
                    array(
                        'Title' => 'Pre-pave',
                    ),
                    array(
                        'Title' => 'Pressure'
                    ),
                )
            );
            $price = array(
                'Title' => 'PRICE',
                'Value' => 'PRI_CE',
                'List' => array(
                    array(
                        'Title' => 'Under Rs.10000',
                        'Value' => '10000-0',
                    ),
                    array(
                        'Title' => 'Rs.10000 To Rs.20000',
                        'Value' => '10000-20000',
                    ),
                    array(
                        'Title' => 'Rs.20000 To Rs.30000',
                        'Value' => '20000-30000',
                    ),
                    array(
                        'Title' => 'Rs.30000 To Rs.50000',
                        'Value' => '30000-50000',
                    ),
                    array(
                        'Title' => 'Above Rs.50000',
                        'Value' => '0-50000'
                    ),
                )
            );
            $more = array(
                'Title' => 'MORE FILTERS',
                'Value' => 'MORE_FILTERS',
                "ListOne" => array(
                    'Title' => 'Shop By Ocassion',
                    'Value' => 'Shop_By_Ocassion',
                    'List' => array(
                        array(
                            "Title" => 'Octa Petalos Diamond Ring',
                            "Value" => 'Octa-Petalos-Diamond-Ring',
                        ),
                        array(
                            "Title" => 'Round Cluster Diamond Ring',
                            "Value" => 'Round-Cluster-Diamond-Ring',
                        ),
                        array(
                            "Title" => 'Daisy Grace Diamond Ring',
                            "Value" => 'Daisy-Grace-Diamond-Ring',
                        ),
                        array(
                            "Title" => 'Entwined Leaves Diamond Ring',
                            "Value" => 'Entwined-Leaves-Diamond-Ring'
                        ),
                        array(
                            "Title" => 'Celsia Diamond Ring',
                            "Value" => 'Celsia-Diamond-Ring'
                        ),
                    ),
                ),
                "ListTwo" => array(
                    'Title' => 'Collection',
                    'value' => 'Colle_ction',
                    'List' => array(
                        array(
                            'Title' => 'CEREMONIAL',
                            'value' => 'CEREM-ONIAL',
                        ),
                        array(
                            'Title' => 'URBANE',
                            'value' => 'URB-ANE',
                        ),
                        array(
                            'Title' => 'EVERLIGHT',
                            'value' => 'EVERL-IGHT',
                        ),
                        array(
                            'Title' => 'ADORE',
                            'value' => 'ADO-RE',
                        ),
                        array(
                            'Title' => 'Flamboyance',
                            'value' => 'Flambo-yance',
                        ),
                        array(
                            'Title' => 'CONTEMPORARY',
                            'value' => 'CONTEM-PORARY',
                        ),
                        array(
                            'Title' => 'WOMEN DAYS',
                            'value' => 'WOMEN-DAYS',
                        ),
                    ),

                ),
            );

            return new Response([
                "status" => true,
                "data" => array(
                    "metal" => array(
                        $metalType,
                        $diamond,
                    ),
                    "weight" => array(
                        $weight,
                    ),
                    "setting" => array(
                        $settingtype,
                    ),
                    "price" => array(
                        $price,
                    ),
                    "more" => array(
                        $more
                    )
                ),
            ]);
        } catch (\Throwable $th) {
            return new Response([
                "status" => false,
                "message" => $th->getMessage()
            ]);
        }
    }
}

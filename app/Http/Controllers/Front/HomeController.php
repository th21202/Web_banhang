<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Http\Controllers\Front\Priduct;
use App\Models\Product;
use App\Services\Product\ProductServiceInterface;

class HomeController extends Controller
{
    //
    private $productService;
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $featuredProducts = $this->productService->getFeaturedProducts();
        // $menProducts = Product::where('featured', true)->where('product_category_id', 1)->get();
        // $womenProducts = Product::where('featured', true)->where('product_category_id', 2)->get();
        //dd($menProducts);
         return view('front.index', compact( 'featuredProducts'));
    }
}

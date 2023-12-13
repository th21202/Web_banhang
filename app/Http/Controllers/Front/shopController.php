<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Brand\BrandServiceInterface;

use App\Services\ProductCategory\ProductCategoryServiceInterface;
use App\Services\ProductCategory\ProductCategoryService;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterfaceInterface;
use App\Repositories\ProductCategory\ProductCategoryRepository;

use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Front\ProductComment;
use App\Models\ProductComments;
use App\Services\Product\ProductServiceInterface;
use App\Services\Product\ProductService;
use App\Services\ProductComment\ProductCommentServiceInterface;
use App\Service\ProductComment\ProductCommentService;
use App\Repositories\ProductComment\ProductCommentRepository;
use App\Repositories\ProductComment\ProductCommentRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
class shopController extends Controller
{
    //
    private $productService;
    private $productCommentService;
    private $productCategoryService;
    private $brandService;

    public function __construct(ProductServiceInterface $productService,
                                ProductCommentServiceInterface $productCommentService,
                                ProductCategoryServiceInterface $productCategoryService,
                                BrandServiceInterface $brandService ){
        $this->productService = $productService;
        $this->productCommentService = $productCommentService;
        $this->productCategoryService = $productCategoryService;
        $this->brandService = $brandService;


    }


    public function show($id){
        // $product = Product::findOrFail($id);
        // $product = $this->productService->find($id);

        // $relatedProducts = Product::where('product_category_id', $product->product_category_id)
        // ->where('tag', $product->tag)
        // ->limit(4)
        // ->get();

        // return view('front.shop.show', compact('product', 'avgRating', 'relatedProducts'));
        //chú ý
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $product = $this->productService->find($id);
        $relatedProducts = $this->productService->getRelatedProducts($product);
        return view('front.shop.show', compact('product', 'relatedProducts', 'categories', 'brands'));

    }
    public function postComment(Request $request){
        $this->productCommentService->create($request->all());
        return redirect()->back();
    }


    public function index(Request $request)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $products =  $this->productService->getProductOnIndex($request);
        return view('front.shop.index', compact('products', 'categories', 'brands'));
        //return view('front.shop.show', compact('products', 'categories', 'brands'));

    }


   public function category($categoryName, Request $request){
       $categories = $this->productCategoryService->all();
       $brands = $this->brandService->all();
       $products=  $this->productService->getProductsByCategory($categoryName, $request);
       return view('front.shop.index', compact('products', 'categories', 'brands'));
       //return view('front.shop.show', compact('products', 'categories', 'brands'));

   }
}

<?php
namespace App\Services\ProductCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\BaseService;
use Illuminate\Http\Request;

use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
class ProductCategoryService extends BaseService implements ProductCategoryServiceInterface{
    public $repository;

    public function __construct(ProductCategoryRepositoryInterface $productCategoryRepository)
    {
        $this->repository = $productCategoryRepository;

    }
}

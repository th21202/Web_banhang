<?php
namespace App\Services\Brand;
use App\Models\Brand;
use App\Services\BaseService;
use App\Repositories\Brand\BrandRepositoryInterface;
class BrandService extends BaseService implements BrandServiceInterface{
    public $repository;

    public function __construct(BrandRepositoryInterface $BrandRepository)
    {
        $this->repository = $BrandRepository;

    }
}

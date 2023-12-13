<?php
namespace App\Services\OrderDetail;
//use App\Models\OrderDetail;
use App\Services\BaseService;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
class OrderDetailService extends BaseService implements OrderDetailServiceInterface{
    public $repository;

    public function __construct(OrderDetailRepositoryInterface $OrderDetailRepository)
    {
        $this->repository = $OrderDetailRepository;

    }
}

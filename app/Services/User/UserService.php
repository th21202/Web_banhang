<?php
namespace App\Services\User;
use App\Models\User;
use App\Services\BaseService;
use App\Repositories\User\UserRepositoryInterface;
class UserService extends BaseService implements UserServiceInterface{
    public $repository;

    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->repository = $UserRepository;

    }
    public function searchAndPaginate(){
        
    }
}

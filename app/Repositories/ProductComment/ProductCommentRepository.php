<?php


namespace App\Repositories\ProductComment;

use Illuminate\Http\Request;

use App\Repositories\BaseRepository;

class ProductCommentRepository extends BaseRepository implements ProductCommentRepositoryInterface
{
    public function getModel()
    {
        return ProductComment::class;
        // TODO: Implement getModel() method.
    }



}

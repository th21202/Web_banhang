<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class ProductComments extends Model
{
    use HasFactory;
    protected $table = 'product_comments';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
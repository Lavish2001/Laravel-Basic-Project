<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['owner_id', 'description', 'image'];
    protected $dates = ['deleted_at'];
    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function post_comment()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}

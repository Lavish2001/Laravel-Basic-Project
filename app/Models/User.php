<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['username', 'email', 'password'];
    protected $dates = ['deleted_at'];
    public $timestamps = true;

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function user_post()
    {
        return $this->hasMany(Post::class, 'owner_id');
        // return $this->hasManyThrough(Post::class, Comment::class, 'user_id', 'id', 'id', 'post_id');
    }
}

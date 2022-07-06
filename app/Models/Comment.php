<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['author'];

    protected $fillable = ['body', 'user_id'];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $with = ['category', 'author', 'comments'];
    protected $fillable = ['body', 'excerpt', 'category_id','slug', 'title', 'user_id'];
    
    public function scopeFilter($query, array $filters) {
        if($filters['search'] ?? false) {
           $query->where(fn($query) => 
            $query->where('title', 'like', '%' . request('search') .'%')
                ->orWhere('body', 'like', '%' . request('search') .'%')    
        );
        };

        if($filters['category'] ?? false) {
            $query->whereHas('category', fn($query) => $query->where('slug', request('category')));
        };

        if($filters['author'] ?? false) {
            $query->whereHas('author', fn($query) => $query->where('username', request('author')));
        };
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }


}

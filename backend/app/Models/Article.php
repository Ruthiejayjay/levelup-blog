<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'slug', 'user_id', 'avatar_path'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function author()
    {
        // this is a relationship towards User model, but we name it differently
        // therefore we must use explicitly state key
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function scopeCategory($builder, $category)
    {
        if ($category === null) {
            return $builder;
        }

        return $builder->with('categories')->whereHas('categories', function ($currentQuery) use ($category) {
            $currentQuery->where('slug', $category);
        });
    }

    public function scopeNewest($builder)
    {
        return $builder->orderBy('created_at', 'desc');
    }

    public function scopeFromUser($builder, $user_id)
    {
        if ($user_id === null) {
            return $builder;
        }

        return $builder->where('user_id', $user_id);
    }

    public function getAvatarPathAttribute($value)
    {
        //return asset($value ? asset('storage/' . $value) : 'https://www.gravatar.com/avatar/' . md5($this->email) . '?s=60&d=mm');
        return asset($value ? Storage::url("$value") : 'https://dummyimage.com/400x400');
    }
}

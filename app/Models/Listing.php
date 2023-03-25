<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable = ['title',  'tags', 'company', 'location', 'email', 'website' , 'description'];

    // creating filter for tags
    public function scopeFilter($query, array $filters)
    {

        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        };

        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        };
    }

    // Relationship between listings and users
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}


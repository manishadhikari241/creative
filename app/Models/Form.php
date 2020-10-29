<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['user_id', 'name', 'title', 'content', 'color', 'created_at', 'updated_at'];

    public function users()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
    public function post_counts()
    {
        return $this->hasone(PostCounts::class, 'form_id');
    }
}

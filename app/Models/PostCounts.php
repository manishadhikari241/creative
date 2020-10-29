<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCounts extends Model
{

    protected $fillable = ['post_count', 'user_id','form_id'];
}

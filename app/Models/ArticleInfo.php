<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleInfo extends BaseModel
{
    protected $table = 'article_info';

    protected $fillable = [
        'article_id',
        'time_to_read',
        'vader',
    ];

    protected $casts = [
        'vader' => 'array'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;;

class article_tag extends Model
{
    protected $table = 'article_tags';
    protected $fillable = ['article_id', 'tag_id'];
}

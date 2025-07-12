<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'writer_id', 'editor_id', 'approver_id', 'title', 'title_slug', 'image', 
        'content', 'summary', 'views', 'status_id', 'notes', 'assigned_editor_id', 'comments_enable'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function AssignedEditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_editor_id', 'id');
    }


    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function ArticleTag(): HasMany
    {
        return $this->hasMany(Article_Tag::class, 'article_id', 'id');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(Article_Revision::class, 'article_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'article_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'article_id');
    }
    // Quan hệ Many-to-Many với Tag
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tags', 'article_id', 'tag_id');
    }
}

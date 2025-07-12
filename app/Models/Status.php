<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class status extends Model
{
    use HasFactory;
    protected $fillable = ['status'];
    
    public function articles():HasMany
    {
        return $this->hasMany(Article::class);
    }
    public function notes():HasMany
    {
        return $this->hasMany(Note::class);
    }
    public function getBadgeClassAttribute()
    {
        return match ($this->status) {
            config('status.published'),
            config('status.approved_edit') => 'text-success bg-light-success',

            config('status.pending_review'),
            config('status.waiting_editor_edit'),
            config('status.pending_approve'),
            config('status.waiting_approver_edit') => 'text-warning bg-light-warning',

            config('status.draft') => 'text-primary bg-light-primary',

            config('status.rejected'),
            config('status.unpublished') => 'text-danger bg-light-danger',

            default => 'text-secondary bg-light-secondary',
        };
    }
}

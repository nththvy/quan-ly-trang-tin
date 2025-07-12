<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'image',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     /**
     * Quan hệ 1-N: Mỗi user thuộc về một role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function writtenArticles(): HasMany
    {
        return $this->hasMany(Article::class, 'writer_id');
    }

    /**
     * Quan hệ: Editor có thể chỉnh sửa nhiều bài viết.
     */
    public function editedArticles(): HasMany
    {
        return $this->hasMany(Article::class, 'editor_id');
    }

    /**
     * Quan hệ: Approver có thể duyệt nhiều bài viết.
     */
    public function approvedArticles(): HasMany
    {
        return $this->hasMany(Article::class, 'approver_id');
    }
    
    //Vai tro mac dinh
    protected static function boot()
    {
        
        parent::boot();
        
        static::creating(function ($user) {
            if (!$user->role_id) {
                $user->role_id = Role::where('name', 'user')->value('id');
            }
        });
    }
}

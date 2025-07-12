<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role_permission extends Model
{
    protected $table = 'role_permissions';
    protected $fillable = ['role_id', 'permission_id'];
    
    public function Role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    
    public function Permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}
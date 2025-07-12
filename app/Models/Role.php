<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name'];
    
    public function RolePermission(): HasMany
    {
        return $this->hasMany(Role_Permission::class, 'role_id', 'id');
    }
}

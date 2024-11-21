<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Users;

class MRole extends Model
{
    use SoftDeletes;

    protected $table = 'm_roles';

    public function users() {
        return $this->hasMany(Users::class, 'role_id', 'id');
    }
}

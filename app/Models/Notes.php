<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Notes extends Model
{
    use SoftDeletes;

    protected $table = 'notes';

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecordDetail extends Model
{
    use SoftDeletes;
    protected $table = 'medical_record_details';
}

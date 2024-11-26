<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalRecordDetail;

class MedicalRecord extends Model
{
    use SoftDeletes;
    protected $table = 'medical_records';

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function record_detail() {
        return $this->hasMany(MedicalRecordDetail::class, 'record_id', 'id');
    }
}

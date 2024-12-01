<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\MedicalRecord;

class MedicalRecordDetail extends Model
{
    use SoftDeletes;
    protected $table = 'medical_record_details';

    public function master_record() {
        return $this->belongsTo(MedicalRecord::class, 'record_id', 'id');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;

class RekamMedisDetialComponents extends Component
{
    public $detail_id;

    public function mount($id)
    {
        $this->detail_id = $id;
    }

    public function loadAllData() {
        $findData = MedicalRecord::find((int) $this->detail_id);
        if(!$findData){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Data rekam medis tidak ditemukan!'
            ]);
            return redirect()->route('rekam-medis');
        }
    }

    public function render()
    {
        return view('livewire.rekam-medis-detial-components');
    }
}

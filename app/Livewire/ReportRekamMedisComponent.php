<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;

class ReportRekamMedisComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $inputSearch = '';
    public $detailData;

    public function detailRekamMedis(int $data_id) {
        $findData = MedicalRecordDetail::
        with(['master_record:id,record_num,user_name,patient_name,status'])->
        select('id','record_num','record_id','complaint','physical_exam','diagnosis','medicine_advice','created_by','created_at')->
        find($data_id);
        
        if(!$findData){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Data rekam medis tidak ditemukan!'
            ]);
            return;
        }

        $this->detailData = json_decode(json_encode($findData));
        $this->dispatch('open-modal');
    }

    public function loadAllData() {
        $loadData = MedicalRecordDetail::whereHas('master_record', function($query) {
            $query->whereRaw('LOWER(record_num) LIKE ?', ['%' . strtolower($this->inputSearch) . '%'])
            ->orWhereRaw('LOWER(patient_name) LIKE ?', ['%' . strtolower($this->inputSearch) . '%']);
        })
        ->with(['master_record:id,record_num,user_name,patient_name,status'])
        ->select('id','record_num','record_id','created_at')
        ->paginate(10);

        return [
            'loadData' => $loadData
        ];
    }

    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Report Rekam Medis',
            'icon' => 'bx bx-receipt'
        ]);
        
        return view('livewire.report-rekam-medis-component', $this->loadAllData());
    }
}

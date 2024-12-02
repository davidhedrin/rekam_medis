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

    public $inputSearch = '', $startDateSearch, $endDateSearch;
    public $detailData;

    public function mount() {
        $this->refreshDateParam();
    }

    public function refreshDateParam() {
        $dateNow = Carbon::now();
        $this->startDateSearch = $dateNow->format('Y-m-d');
        $this->endDateSearch = $dateNow->format('Y-m-d');
    }

    public function detailRekamMedis(int $data_id) {
        $findData = MedicalRecordDetail::
        with([
            'master_record:id,user_id,patient_id,record_num,user_name,patient_name,status,desc',
            'master_record.patient:id,no_hp,gender,blood_type',
            
            'master_record.user:id,fullname,role_id',
            'master_record.user.master_role:id,name'
        ])->
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
        $dateNow = Carbon::now();
        if(!$this->startDateSearch || $this->startDateSearch == "") $this->startDateSearch = $dateNow->format('Y-m-d');
        if(!$this->endDateSearch || $this->endDateSearch == "") $this->endDateSearch = $dateNow->format('Y-m-d');

        $loadData = MedicalRecordDetail::whereHas('master_record', function($query) {
            $query->whereRaw('LOWER(record_num) LIKE ?', ['%' . strtolower($this->inputSearch) . '%'])
            ->orWhereRaw('LOWER(patient_name) LIKE ?', ['%' . strtolower($this->inputSearch) . '%']);
        })
        ->with(['master_record:id,record_num,user_name,patient_name,status'])
        ->select('id','record_num','record_id','created_at')
        ->whereBetween('created_at', [
            $this->startDateSearch && $this->startDateSearch != "" ? Carbon::parse($this->startDateSearch)->format('Y-m-d 00:00:00') : $dateNow->startOfDay(),
            $this->endDateSearch && $this->endDateSearch != "" ? Carbon::parse($this->endDateSearch)->format('Y-m-d 23:59:59') : $dateNow->endOfDay()
        ])
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

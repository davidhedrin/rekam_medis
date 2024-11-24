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

class RekamMedisComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $record_num, $user_id, $user_name, $patient_id, $patient_name, $desc;
    public $idDataEdit, $isStore = true;
    
    public function ClearData() {
        $this->record_num = null;
        $this->user_id = null;
        $this->user_name = null;
        $this->patient_id = null;
        $this->patient_name = null;
        $this->desc = null;
        $this->isStore = true;
        
        $this->idDataEdit = null;
    }

    public function updated($fields) {
        $this->validateOnly($fields, [
            'patient_id' => 'required',
        ]);
    }

    public function actionForm() {
        if($this->isStore == true) $this->storeData();
        else if($this->isStore == false) $this->updateData();
    }
    
    public function storeData() {
        $this->validate([
            'patient_id' => 'required',
        ]);

        $findData = Patient::find((int) $this->patient_id);
        if(!$findData){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Data pasien tidak ditemukan!'
            ]);
            return;
        }

        try{
            $auth = Auth::user();
            DB::beginTransaction();
            
            $record_num = 'RM' . Carbon::now()->timestamp . strtoupper(Str::random(6));
            $newData = new MedicalRecord;
            $newData->record_num = $record_num;
            $newData->user_id = $auth->id;
            $newData->user_name = $auth->fullname;
            $newData->patient_id = $findData->id;
            $newData->patient_name = $findData->fullname;
            $newData->desc = $this->desc;
            $newData->created_by = $auth->username;
            $newData->save();

            DB::commit();
            
            $this->ClearData();
            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Simpan Berhasil',
              'status' => 'success',
              'message' => 'Rekam medis baru berhasil ditambahkan!'
            ]);

            return redirect()->route('rekam-medis-detail', ['id' => $id]);
        }catch(Exception $e){
            DB::rollBack();
            $error_msg = $e->getMessage();
            
            session()->flash('msgAlert', [
              'title' => 'Gagal Menyimpan',
              'status' => 'warning',
              'message' => $error_msg
            ]);
        }
    }

    public function loadAllData(){
        $loadData = MedicalRecord::select('id','record_num','user_id','user_name','patient_id','patient_name')->
        paginate(10);

        return [
            'loadData' => $loadData
        ];
    }

    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Rekam Medis',
            'icon' => 'bx bx-book-bookmark'
        ]);

        return view('livewire.rekam-medis-component', $this->loadAllData());
    }
}

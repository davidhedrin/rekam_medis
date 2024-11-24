<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Patient;

class PatientComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $patient_id, $fullname, $no_hp, $gender, $birth_date, $birth_place, $blood_type, $religion, $address, $desc;
    public $idDataEdit, $isStore = true;
    public $bloodTypes = [
        [ 'text' => 'A', 'value' => 'A' ],
        [ 'text' => 'B', 'value' => 'B' ],
        [ 'text' => 'AB', 'value' => 'AB' ],
        [ 'text' => 'O', 'value' => 'O' ],
        [ 'text' => 'A+', 'value' => 'A+' ],
        [ 'text' => 'A-', 'value' => 'A-' ],
        [ 'text' => 'B+', 'value' => 'B+' ],
        [ 'text' => 'B-', 'value' => 'B-' ],
        [ 'text' => 'O+', 'value' => 'O+' ],
        [ 'text' => 'O-', 'value' => 'O-' ],
    ];
    
    public function ClearData() {
        $this->fullname = null;
        $this->no_hp = null;
        $this->gender = null;
        $this->birth_date = null;
        $this->birth_place = null;
        $this->blood_type = null;
        $this->religion = null;
        $this->address = null;
        $this->desc = null;
        $this->isStore = true;
        
        $this->idDataEdit = null;
    }

    public function updated($fields) {
        $this->validateOnly($fields, [
            'fullname' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
        ]);
    }

    public function actionForm() {
        if($this->isStore == true) $this->storeData();
        else if($this->isStore == false) $this->updateData();
    }

    public function storeData() {
        $this->validate([
            'fullname' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
        ]);

        try{
            $auth = Auth::user();
            DB::beginTransaction();

            $patient_id = Carbon::now()->timestamp . strtoupper(Str::random(6));
            $newData = new Patient;
            $newData->patient_id = $patient_id;
            $newData->fullname = $this->fullname;
            $newData->no_hp = $this->no_hp;
            $newData->gender = $this->gender;
            $newData->birth_date = $this->birth_date;
            $newData->birth_place = $this->birth_place;
            $newData->blood_type = $this->blood_type;
            $newData->religion = $this->religion;
            $newData->address = $this->address;
            $newData->desc = $this->desc;
            $newData->created_by = $auth->username;
            $newData->save();
            
            DB::commit();
            
            $this->ClearData();
            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Simpan Berhasil',
              'status' => 'success',
              'message' => 'Pasien baru berhasil ditambahkan!'
            ]);
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

    public function openDetailData($id) {
        $this->ClearData();
        $findData = Patient::find($id);

        if(!$findData){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Data pasien tidak ditemukan!'
            ]);
            return;
        }

        $this->isStore = false;
        $this->patient_id = $findData->patient_id;
        $this->fullname = $findData->fullname;
        $this->no_hp = $findData->no_hp;
        $this->gender = $findData->gender;
        $this->birth_date = $findData->birth_date;
        $this->birth_place = $findData->birth_place;
        $this->blood_type = $findData->blood_type;
        $this->religion = $findData->religion;
        $this->address = $findData->address;
        $this->desc = $findData->desc;
        $this->dispatch('open-edit-modal');

        $this->idDataEdit = $id;
    }

    public function updateData() {
        try{
            $findData = Patient::find($this->idDataEdit);
            if(!$findData){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Ditemukan!',
                    'status' => 'warning',
                    'message' => 'Data pasien tidak ditemukan!'
                ]);
                return;
            }
            
            $this->validate([
                'fullname' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'birth_place' => 'required',
            ]);

            $auth = Auth::user();
            DB::beginTransaction();

            $findData->fullname = $this->fullname;
            $findData->no_hp = $this->no_hp;
            $findData->gender = $this->gender;
            $findData->birth_date = $this->birth_date;
            $findData->birth_place = $this->birth_place;
            $findData->blood_type = $this->blood_type;
            $findData->religion = $this->religion;
            $findData->address = $this->address;
            $findData->desc = $this->desc;
            $findData->updated_by = $auth->username;
            $findData->save();
            
            DB::commit();
            
            $this->ClearData();
            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Update Berhasil',
              'status' => 'success',
              'message' => 'Data pasien berhasil diperbaharui!'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            $error_msg = $e->getMessage();
            
            session()->flash('msgAlert', [
              'title' => 'Gagal Update',
              'status' => 'warning',
              'message' => $error_msg
            ]);
        }
    }

    public function loadAllData(){
        $loadData = Patient::select('id','patient_id','fullname','no_hp','gender','birth_date')->
        paginate(10);

        return [
            'loadData' => $loadData
        ];
    }

    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Pasien Management',
            'icon' => 'bx bx-user-pin'
        ]);

        return view('livewire.patient-component', $this->loadAllData());
    }
}

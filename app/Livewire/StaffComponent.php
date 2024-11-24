<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\MRole;

class StaffComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $username, $password, $co_password, $fullname, $role_id, $email;
    public $idDataEdit, $isStore = true;

    public function ClearData() {
        $this->username = null;
        $this->password = null;
        $this->co_password = null;
        $this->fullname = null;
        $this->role_id = null;
        $this->email = null;
        $this->isStore = true;
        
        $this->idDataEdit = null;
    }

    public function updated($fields) {
        $this->validateOnly($fields, [
            'username' => 'required|unique:users,username',
            'password' => 'required|same:co_password|min:6',
            'co_password' => 'required|same:password|min:6',
            'fullname' => 'required',
            'role_id' => 'required',
            'email' => 'email',
        ]);
    }

    public function actionForm() {
        if($this->isStore == true) $this->storeNewData();
        else if($this->isStore == false) $this->updateData();
    }

    public function storeNewData() {
        $this->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|same:co_password|min:6',
            'co_password' => 'required|same:password|min:6',
            'fullname' => 'required',
            'role_id' => 'required',
            'email' => 'email',
        ]);

        try{
            $auth = Auth::user();
            DB::beginTransaction();

            $newData = new User;
            $newData->username = $this->username;
            $newData->password = Hash::make($this->password);
            $newData->fullname = $this->fullname;
            $newData->role_id = $this->role_id;
            $newData->email = $this->email;
            $newData->created_by = $auth->username;
            $newData->save();
            
            DB::commit();
            
            $this->ClearData();
            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Simpan Berhasil',
              'status' => 'success',
              'message' => 'Staff baru berhasil ditambahkan!'
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
        $findData = User::find($id);

        if(!$findData){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Data user tidak ditemukan!'
            ]);
            return;
        }

        $this->isStore = false;
        $this->username = $findData->username;
        $this->fullname = $findData->fullname;
        $this->role_id = $findData->role_id;
        $this->email = $findData->email;
        $this->dispatch('open-edit-modal');

        $this->idDataEdit = $id;
    }

    public function updateData() {
        try{
            $findData = User::find($this->idDataEdit);
            if(!$findData){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Ditemukan!',
                    'status' => 'warning',
                    'message' => 'Data user tidak ditemukan!'
                ]);
                return;
            }
            
            $rulesValidate = [
                'fullname' => 'required',
                'role_id' => 'required',
                'email' => 'email',
            ];
    
            if($findData->username != $this->username) $rulesValidate['username'] = 'required|unique:users,username';
            $this->validate($rulesValidate);

            
            $auth = Auth::user();
            DB::beginTransaction();

            $findData->username = $this->username;
            $findData->fullname = $this->fullname;
            $findData->role_id = $this->role_id;
            $findData->email = $this->email;
            $findData->updated_by = $auth->username;
            $findData->save();
            
            DB::commit();
            
            $this->ClearData();
            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Update Berhasil',
              'status' => 'success',
              'message' => 'Data staff berhasil diperbaharui!'
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
        $loadData = User::with(['master_role:id,slug,name'])->
        select('id','username','fullname','role_id','created_by','created_at')->
        paginate(10);

        $dataMasterRole = MRole::select('id','name')->get();
        return [
            'loadData' => $loadData,
            'dataMasterRole' => $dataMasterRole
        ];
    }

    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Staff Management',
            'icon' => 'bx bx-group'
        ]);

        return view('livewire.staff-component', $this->loadAllData());
    }
}

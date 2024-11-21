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

    public function ClearData() {
        $this->username = null;
        $this->password = null;
        $this->co_password = null;
        $this->fullname = null;
        $this->role_id = null;
        $this->email = null;
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

    public function loadAllData(){
        $loadDataUser = User::with(['master_role:id,slug,name'])->
        select('id','username','fullname','role_id','created_by','created_at')->
        paginate(10);

        $dataMasterRole = MRole::select('id','name')->get();
        return [
            'loadDataUser' => $loadDataUser,
            'dataMasterRole' => $dataMasterRole
        ];
    }

    public function storeNewStaff() {
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

            $newStaff = new User;
            $newStaff->username = $this->username;
            $newStaff->password = Hash::make($this->password);
            $newStaff->fullname = $this->fullname;
            $newStaff->role_id = $this->role_id;
            $newStaff->email = $this->email;
            $newStaff->created_by = $auth->username;
            $newStaff->save();
            
            DB::commit();
            
            $this->ClearData();
            // $this->dispatchBrowserEvent('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Simpan Berhasil',
              'status' => 'success',
              'message' => 'Staff baru berhasil ditambahkan!'
            ]);
        }catch(Exception $e){
            DB::rollBack();
            $error_msg = $e->getMessage();
            
            session()->flash('msgAlert', [
              'title' => 'Gagal Login',
              'status' => 'warning',
              'message' => $error_msg
            ]);
        }
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
<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

use App\Models\User;

class ProfileComponent extends Component
{
    public $curr_password, $new_pass, $new_co_pass;

    public function updated($fields) {
        $this->validateOnly($fields, [
            'curr_password' => 'required|min:6',
            'new_pass' => 'required|same:new_co_pass|min:6',
            'new_co_pass' => 'required|same:new_pass|min:6',
        ]);
    }
    
    public function ClearData() {
        $this->curr_password = null;
        $this->new_pass = null;
        $this->new_co_pass = null;
    }

    public function confirmChangePass(int $id) {
        $this->validate([
            'curr_password' => 'required|min:6',
            'new_pass' => 'required|same:new_co_pass|min:6',
            'new_co_pass' => 'required|same:new_pass|min:6',
        ]);

        $this->dispatch('open-confirm', [
            'title' => 'Konfirmasi Tindakan',
            'text' => 'Apakah yakin ingin mengubah password?',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Lanjut',
            'cancelButtonText' => 'Batal',
            'reverseButtons' => true,
            'data_id' => (int) $id,
            'triger_fn' => 'submitChangePass'
        ]);
    }

    #[On('submitChangePass')] 
    public function submitChangePass(int $data_id) {
        try{
            $findData = User::find($data_id);
            if(!$findData){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Ditemukan!',
                    'status' => 'warning',
                    'message' => 'Detail user tidak ditemukan!'
                ]);
                return redirect()->route('logout');
            }
            
            if(!Hash::check($this->curr_password, $findData->password)){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Cocok!',
                    'status' => 'warning',
                    'message' => 'Password saat ini tidak sesuai!'
                ]);
                return;
            }

            DB::beginTransaction();

            $findData->password = Hash::make($this->new_pass);
            $findData->save();

            DB::commit();
            
            $this->ClearData();
            session()->flash('msgAlert', [
              'title' => 'Update Berhasil',
              'status' => 'success',
              'message' => 'Password batu telah berhasil diperbaharui!'
            ]);

            return redirect()->route('logout');
        }catch(Exception $e){
            DB::rollBack();
            $error_msg = $e->getMessage();
            
            session()->flash('msgAlert', [
              'title' => 'Gagal Mengubah',
              'status' => 'warning',
              'message' => $error_msg
            ]);
        }
    }

    public function loadAllData() {
        $auth = Auth::user();
        $loadUser = User::with(['master_role'])->
        find((int) $auth->id);
        
        return [
            'loadUser' => $loadUser
        ];
    }

    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Profil Pengguna',
            'icon' => 'bx bx-user-circle'
        ]);

        return view('livewire.profile-component', $this->loadAllData());
    }
}

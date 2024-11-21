<?php

namespace App\Livewire;

use Livewire\Component;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginComponent extends Component
{
  public $username, $password;
  
  public function updated($fields) {
    $this->validateOnly($fields, [
      'username' => 'required',
      'password' => 'required'
    ]);
  }

  public function loginUser() {
    $this->validate([
      'username' => 'required',
      'password' => 'required'
    ]);

    try{
      $user = User::where('username', $this->username)->first();
      if($user){
        if(Hash::check($this->password, $user->password)){
          if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            return redirect()->route('home');
          } else {
            session()->flash('msgAlert', [
              'title' => 'Gagal Login',
              'status' => 'warning',
              'message' => 'Telah terjadi kesalahan, Ulangi beberapa saat lagi!'
            ]);
          }
        }else{
          session()->flash('msgAlert', [
            'title' => 'Password Gagal',
            'status' => 'warning',
            'message' => 'Kata sandi yang dimasukkan tidak sesuai!'
          ]);
        }
      }else{
        session()->flash('msgAlert', [
          'title' => 'Tidak Ditemukan',
          'status' => 'warning',
          'message' => 'Akun username yang dimasukkan tidak ditemukan!'
        ]);
      }
    }catch(Exception $e){
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
    return view('livewire.login-component');
  }
}

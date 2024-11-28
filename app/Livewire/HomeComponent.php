<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

use App\Models\Notes;
use App\Models\Patient;
use App\Models\User;
use App\Models\MedicalRecord;

class HomeComponent extends Component
{
    public $conten_notes;

    public function mount() {
        $this->loadData();
    }

    public function loadData() {
        $auth = Auth::user();
        $findData = Notes::where('user_id', $auth->id)->first();
        if($findData) $this->conten_notes = $findData->content;
    }

    #[On('set_session_limit')] 
    public function set_session_limit($title, $msg, $status) {
        session()->flash('msgAlert', [
            'title' => $title,
            'status' => $status,
            'message' => $msg
        ]);
    }

    public function submitNotes() {
        try{
            $auth = Auth::user();
            DB::beginTransaction();

            DB::table((new Notes)->getTable())->updateOrInsert(
                ['user_id' => $auth->id],
                [
                    'content' => $this->conten_notes,
                    'updated_by' => $auth->username,
                    'created_by' => $auth->username,
                ]
            );
            
            DB::commit();

            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Simpan Berhasil',
              'status' => 'success',
              'message' => 'Catatan telah berhasil disimpan!'
            ]);
            $this->loadData();
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

    public function loadAllData() {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        return [
            'count_patient' => [
                'patient' => Patient::count(),
                'month' => Patient::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count()
            ],
            'count_user' => User::count() ,
            'count_med_rec' => MedicalRecord::count(),
        ];
    }

    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Dashboard, Selamat Datang!',
            'icon' => 'bx bx-tachometer'
        ]);
        return view('livewire.home-component', $this->loadAllData());
    }
}
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

class RekamMedisDetialComponents extends Component
{
    public $detail_id, $recordDatas = null;

    public $record_num, $record_id, $complaint, $diagnosis, $drag, $suggestion;
    public $idDataEdit, $isStore = true;

    public function mount($id)
    {
        $this->detail_id = $id;

        $findData = MedicalRecord::with([
            'user:id,fullname,role_id',
            'patient:id,no_hp,gender,blood_type',
            'user.master_role:id,name'
        ])->
        select('id','record_num','user_id','user_name','patient_id','patient_name','desc','created_at','status')->
        withCount('record_detail')->
        find((int) $this->detail_id);
        if(!$findData){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Data rekam medis tidak ditemukan!'
            ]);
            return redirect()->route('rekam-medis');
        }

        $this->recordDatas = $findData;
    }

    public function ClearData() {
        $this->record_num = null;
        $this->record_id = null;
        $this->complaint = null;
        $this->diagnosis = null;
        $this->drag = null;
        $this->suggestion = null;

        $this->isStore = true;
        $this->idDataEdit = null;
    }

    public function updated($fields) {
        $this->validateOnly($fields, [
            'complaint' => 'required',
        ]);
    }

    public function actionForm() {
        if($this->isStore == true) $this->storeData();
        else if($this->isStore == false) $this->updateData();
    }

    public function storeData() {
        $this->validate([
            'complaint' => 'required',
        ]);

        if(!$this->recordDatas){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Rekam medis tidak ditemukan, Silahkan muat ulang halaman!'
            ]);
            return;
        }

        if($this->recordDatas->status == false){
            session()->flash('msgAlert', [
                'title' => 'Gagal Menyimpan!',
                'status' => 'warning',
                'message' => 'Status rekam medis telah selesai/ditutup!'
            ]);
            return;
        }

        try{
            $auth = Auth::user();
            DB::beginTransaction();

            $record_num = 'RMD/' . Carbon::now()->timestamp . strtoupper(Str::random(6));
            $newData = new MedicalRecordDetail;
            $newData->record_num = $record_num;
            $newData->record_id = $this->recordDatas->id;
            $newData->complaint = $this->complaint;
            $newData->diagnosis = $this->diagnosis;
            $newData->drag = $this->drag;
            $newData->suggestion = $this->suggestion;
            $newData->created_by = $auth->fullname;
            $newData->save();

            DB::commit();
            $this->ClearData();
            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Simpan Berhasil',
              'status' => 'success',
              'message' => 'Rekam medis baru berhasil ditambahkan!'
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
        $findData = MedicalRecordDetail::find($id);

        if(!$findData){
            session()->flash('msgAlert', [
                'title' => 'Tidak Ditemukan!',
                'status' => 'warning',
                'message' => 'Detail rekam medis tidak ditemukan!'
            ]);
            return;
        }

        $this->isStore = false;
        $this->complaint = $findData->complaint;
        $this->diagnosis = $findData->diagnosis;
        $this->drag = $findData->drag;
        $this->suggestion = $findData->suggestion;
        $this->dispatch('open-edit-modal');

        $this->idDataEdit = $id;
    }

    public function updateData() {
        try{
            $findData = MedicalRecordDetail::find($this->idDataEdit);
            if(!$findData){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Ditemukan!',
                    'status' => 'warning',
                    'message' => 'Detail rekam medis tidak ditemukan!'
                ]);
                return;
            }
            
            $this->validate([
                'complaint' => 'required',
            ]);

            $auth = Auth::user();
            DB::beginTransaction();

            $findData->complaint = $this->complaint;
            $findData->diagnosis = $this->diagnosis;
            $findData->drag = $this->drag;
            $findData->suggestion = $this->suggestion;
            $findData->updated_by = $auth->username;
            $findData->save();
            
            DB::commit();
            
            $this->ClearData();
            $this->dispatch('close-form-modal');
            session()->flash('msgAlert', [
              'title' => 'Update Berhasil',
              'status' => 'success',
              'message' => 'Detail rekam medis berhasil diperbaharui!'
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

    public function confirmAction(int $id) {
        $this->dispatch('open-confirm', [
            'title' => 'Konfirmasi Tindakan',
            'text' => 'Apakah Anda yakin ingin melanjutkan?',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Lanjut',
            'cancelButtonText' => 'Batal',
            'reverseButtons' => true,
            'data_id' => (int) $id,
            'triger_fn' => 'handleConfirm'
        ]);
    }

    #[On('handleConfirm')] 
    public function handleConfirm(int $data_id) {
        try{
            $findData = MedicalRecord::with('record_detail')->find($data_id);
            if(!$findData){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Ditemukan!',
                    'status' => 'warning',
                    'message' => 'Data rekam medis tidak ditemukan!'
                ]);
                return;
            }

            $auth = Auth::user();
            DB::beginTransaction();

            $findData->record_detail()->update(['deleted_by' => $auth->username]);

            $findData->deleted_by = $auth->username;
            $findData->save();

            $findData->record_detail()->delete();
            $findData->delete();

            DB::commit();
            
            session()->flash('msgAlert', [
                'title' => 'Delete Berhasil',
                'status' => 'success',
                'message' => 'Data rekam medis berhasil dihapus!'
            ]);
            return redirect()->route('rekam-medis');
        }catch(Exception $e){
            DB::rollBack();
            $error_msg = $e->getMessage();
            
            session()->flash('msgAlert', [
              'title' => 'Gagal Delete',
              'status' => 'warning',
              'message' => $error_msg
            ]);
        }
    }

    public function confirmStatus(int $id) {
        $this->dispatch('open-confirm', [
            'title' => 'Konfirmasi Tindakan',
            'text' => 'Apakah Anda yakin ingin menyelesaikan?',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Lanjut',
            'cancelButtonText' => 'Batal',
            'reverseButtons' => true,
            'data_id' => (int) $id,
            'triger_fn' => 'handleUpdateStatus'
        ]);
    }

    #[On('handleUpdateStatus')] 
    public function handleUpdateStatus(int $data_id) {
        try{
            $findData = MedicalRecord::with('record_detail')->find($data_id);
            if(!$findData){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Ditemukan!',
                    'status' => 'warning',
                    'message' => 'Data rekam medis tidak ditemukan!'
                ]);
                return;
            }

            $auth = Auth::user();
            DB::beginTransaction();

            $findData->updated_by = $auth->username;
            $findData->status = false;
            $findData->save();

            DB::commit();
            
            session()->flash('msgAlert', [
                'title' => 'Delete Berhasil',
                'status' => 'success',
                'message' => 'Status rekam medis berhasil diupdate!'
            ]);
            $this->mount($this->detail_id);
        }catch(Exception $e){
            DB::rollBack();
            $error_msg = $e->getMessage();
            
            session()->flash('msgAlert', [
              'title' => 'Gagal Updated',
              'status' => 'warning',
              'message' => $error_msg
            ]);
        }
    }

    public function generatePdf(int $id) {
        try{
            $findData = MedicalRecord::with([
                'user:id,fullname,role_id',
                'patient:id,no_hp,gender,blood_type',

                'record_detail:record_id,complaint,diagnosis,drag,suggestion,created_by,created_at'
            ])->
            select('id','record_num','user_id','user_name','patient_id','patient_name','desc','created_at')->
            withCount('record_detail')->
            find($id);
            if(!$findData){
                session()->flash('msgAlert', [
                    'title' => 'Tidak Ditemukan!',
                    'status' => 'warning',
                    'message' => 'Data rekam medis tidak ditemukan!'
                ]);
                return;
            }

            $date = Carbon::now();
            $formattedDate = $date->locale('id')->isoFormat('D MMMM YYYY');
            $data = [
                'data' => $findData,
                'docter' => 'IR. Totok Andi Prasetyo, MT, TN',
                'paraf_title' => 'Bekasi, ' . $formattedDate
            ];

            $pdf = Pdf::loadView('Pdf-rekam-medis', $data)->setOption([
                'defaultPaperSize' => 'a4',
                'dpi' => 150,
            ]);
            return response()->streamDownload(function() use ($pdf){
                echo $pdf->stream();
            }, 'rekam_medis.pdf');
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            
            session()->flash('msgAlert', [
              'title' => 'Gagal Menyimpan',
              'status' => 'warning',
              'message' => $error_msg
            ]);
        }
    }

    public function loadAllData() {
        $recordDetails = MedicalRecordDetail::where('record_id', $this->recordDatas->id)->
        select('id','record_num','record_id','complaint','diagnosis','drag','suggestion','created_by','created_at')->
        paginate(10);

        return [
            'recordDatas' => $this->recordDatas,
            'recordDetails' => $recordDetails
        ];
    }

    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Rekam Medis / Detail',
            'icon' => 'bx bx-book-add'
        ]);
        
        return view('livewire.rekam-medis-detial-components', $this->loadAllData());
    }
}

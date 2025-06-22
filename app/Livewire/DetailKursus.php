<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kursus;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;


class DetailKursus extends Component
{
    #[Layout('layouts.app')]

    public $kursusId;
    public $kursus;
    public $isRegistered = false;
    public $canRegister = false;
    public $pesertaList = [];
    public $materiList = [];
    public $showPesertaModal = false;
    public $showMateriModal = false;

    public function mount($id)
    {
        $this->kursusId = $id;
        $this->loadKursusData();
        $this->checkRegistrationStatus();
        $this->loadPesertaList();
        $this->loadMateriList();
    }

    public function loadKursusData()
    {
        $this->kursus = Kursus::with('user')->findOrFail($this->kursusId);
    }

    public function checkRegistrationStatus()
    {
        $user = Auth::user();

        if ($user->role === 'peserta') {
            // Cek apakah user sudah terdaftar di kursus ini (sesuai model Anda)
            $this->isRegistered = Pendaftaran::where('peserta_id', $user->id)
                ->where('kursus_id', $this->kursusId)
                ->exists();

            $this->canRegister = !$this->isRegistered;
        }
    }

    public function loadPesertaList()
    {
        $this->pesertaList = Pendaftaran::with('user')
            ->where('kursus_id', $this->kursusId)
            ->get();
    }

    public function loadMateriList()
    {
        // Load materi berdasarkan kursus_id
        $this->materiList = Materi::where('kursus_id', $this->kursusId)->get();
    }

    public function daftar()
    {
        if (!$this->canRegister) {
            session()->flash('error', 'Anda sudah terdaftar di kursus ini atau tidak memiliki akses untuk mendaftar.');
            return;
        }

        try {
            Pendaftaran::create([
                'peserta_id' => Auth::id(), // Sesuai dengan field di model Anda
                'kursus_id' => $this->kursusId,
                'status' => 'aktif'
            ]);

            $this->isRegistered = true;
            $this->canRegister = false;
            $this->loadPesertaList();

            session()->flash('message', 'Berhasil mendaftar kursus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mendaftar kursus. Silakan coba lagi.');
        }
    }

    public function batalDaftar()
    {
        if (!$this->isRegistered) {
            session()->flash('error', 'Anda belum terdaftar di kursus ini.');
            return;
        }

        try {
            Pendaftaran::where('peserta_id', Auth::id()) // Sesuai dengan field di model Anda
                ->where('kursus_id', $this->kursusId)
                ->delete();

            $this->isRegistered = false;
            $this->canRegister = true;
            $this->loadPesertaList();

            session()->flash('message', 'Berhasil membatalkan pendaftaran kursus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membatalkan pendaftaran. Silakan coba lagi.');
        }
    }

    public function togglePesertaModal()
    {
        $this->showPesertaModal = !$this->showPesertaModal;
    }

    public function toggleMateriModal()
    {
        $this->showMateriModal = !$this->showMateriModal;
    }

    public function hapusPeserta($pendaftaranId)
    {
        try {
            Pendaftaran::findOrFail($pendaftaranId)->delete();
            $this->loadPesertaList();

            session()->flash('message', 'Peserta berhasil dihapus dari kursus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus peserta. Silakan coba lagi.');
        }
    }

    public function kembali()
    {
        return redirect()->route('kursus.index');
    }

    public function render()
    {
        return view('livewire.detail-kursus');
    }
}
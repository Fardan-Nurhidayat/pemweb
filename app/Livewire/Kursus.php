<?php

namespace App\Livewire;

use App\Models\Kursus as KursusModel;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Kursus extends Component
{
    #[Layout('layouts.app')]

    public $kursusList;
    public $nama_kursus, $durasi, $instruktur_id, $biaya;
    public $kursusId; // untuk edit
    public $isEdit = false;
    public $showForm = false; // untuk toggle form

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $this->kursusList = KursusModel::with('user')->get();
        $instrukturs = User::where('role', "=", "instruktur")->get();

        return view('livewire.kursus', [
            'instrukturs' => $instrukturs
        ]);
    }

    public function resetForm()
    {
        $this->nama_kursus = '';
        $this->durasi = '';
        $this->instruktur_id = '';
        $this->biaya = '';
        $this->kursusId = null;
        $this->isEdit = false;
        $this->showForm = false;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }

    public function save()
    {
        $this->validate([
            'nama_kursus' => 'required|string|max:255',
            'durasi' => 'required|integer|min:1',
            'instruktur_id' => 'required|exists:users,id',
            'biaya' => 'required|integer|min:0',
        ]);

        KursusModel::create([
            'nama_kursus' => $this->nama_kursus,
            'durasi' => $this->durasi,
            'instruktur_id' => $this->instruktur_id,
            'biaya' => $this->biaya,
        ]);

        session()->flash('message', 'Kursus berhasil ditambahkan!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $kursus = KursusModel::findOrFail($id);
        $this->kursusId = $kursus->id;
        $this->nama_kursus = $kursus->nama_kursus;
        $this->durasi = $kursus->durasi;
        $this->instruktur_id = $kursus->instruktur_id;
        $this->biaya = $kursus->biaya;
        $this->isEdit = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate([
            'nama_kursus' => 'required|string|max:255',
            'durasi' => 'required|integer|min:1',
            'instruktur_id' => 'required|exists:users,id',
            'biaya' => 'required|integer|min:0',
        ]);

        $kursus = KursusModel::findOrFail($this->kursusId);
        $kursus->update([
            'nama_kursus' => $this->nama_kursus,
            'durasi' => $this->durasi,
            'instruktur_id' => $this->instruktur_id,
            'biaya' => $this->biaya,
        ]);

        session()->flash('message', 'Kursus berhasil diperbarui!');
        $this->resetForm();
    }

    public function viewDetail($id)
    {
        // Contoh: redirect ke halaman detail kursus
        return redirect()->route('kursus.detail', $id);
    }

    public function delete($id)
    {
        KursusModel::destroy($id);
        session()->flash('message', 'Kursus berhasil dihapus!');
    }
}
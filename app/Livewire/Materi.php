<?php

namespace App\Livewire;

use App\Models\Materi as MateriModel;
use App\Models\Kursus;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Materi extends Component
{
    #[Layout('layouts.app')]

    public $materiList;
    public $judul, $deskripsi, $kursus_id;
    public $materiId; // untuk edit
    public $isEdit = false;
    public $showForm = false; // untuk toggle form

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $this->materiList = MateriModel::with('kursus')->get(); 
        $kursusList = Kursus::all();

        return view('livewire.materi', [
            'kursusList' => $kursusList
        ]);
    }

    public function resetForm()
    {
        $this->judul = '';
        $this->deskripsi = '';
        $this->kursus_id = '';
        $this->materiId = null;
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kursus_id' => 'required|exists:kursus,id',
        ]);

        MateriModel::create([
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'kursus_id' => $this->kursus_id,
        ]);

        session()->flash('message', 'Materi berhasil ditambahkan!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $materi = MateriModel::findOrFail($id);
        $this->materiId = $materi->id;
        $this->judul = $materi->judul;
        $this->deskripsi = $materi->deskripsi;
        $this->kursus_id = $materi->kursus_id;
        $this->isEdit = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kursus_id' => 'required|exists:kursus,id',
        ]);

        $materi = MateriModel::findOrFail($this->materiId);
        $materi->update([
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'kursus_id' => $this->kursus_id,
        ]);

        session()->flash('message', 'Materi berhasil diperbarui!');
        $this->resetForm();
    }

    public function delete($id)
    {
        MateriModel::destroy($id);
        session()->flash('message', 'Materi berhasil dihapus!');
    }
}

<?php

namespace App\Livewire;

use App\Models\Kursus as KursusModel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log; // Tambahkan ini di bagian atas
use Exception; // Opsional, tapi disarankan untuk diimpor
class Kursus extends Component
{
    use WithPagination,WireUiActions;

    // Properties untuk form
    public $nama_kursus = '';
    public $durasi = '';
    public $instruktur_id = '';
    public $biaya = '';

    // Properties untuk state management
    public $isOpen = false;
    public $isEdit = false;
    public $kursusId = null;
    public $search = '';

    // Validation rules
    protected $rules = [
        'nama_kursus' => 'required|string|max:255',
        'durasi' => 'required|integer|min:1',
        'instruktur_id' => 'required|exists:users,id',
        'biaya' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'nama_kursus.required' => 'Nama kursus wajib diisi.',
        'durasi.required' => 'Durasi kursus wajib diisi.',
        'durasi.integer' => 'Durasi harus berupa angka.',
        'instruktur_id.required' => 'Instruktur wajib dipilih.',
        'instruktur_id.exists' => 'Instruktur yang dipilih tidak valid.',
        'biaya.required' => 'Biaya kursus wajib diisi.',
        'biaya.numeric' => 'Biaya harus berupa angka.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->isEdit = false;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nama_kursus = '';
        $this->durasi = '';
        $this->instruktur_id = '';
        $this->biaya = '';
        $this->kursusId = null;
        $this->resetErrorBag();
    }

    public function store()
    {   
        $this->validate();

        try {
            KursusModel::create([
                'nama_kursus' => $this->nama_kursus,
                'durasi' => $this->durasi,
                'instruktur_id' => $this->instruktur_id,
                'biaya' => $this->biaya,
            ]);

            $this->notification()->success(
                $title = 'Berhasil!',
                $description = 'Kursus berhasil ditambahkan.'
            );

            $this->closeModal();
            $this->resetPage();
        } catch (\Exception $e) {
            // Log error ke storage/logs/laravel.log
            Log::error('Error saat menyimpan kursus: ' . $e->getMessage());

            $this->notification()->error(
                $title = 'Error!',
                $description = 'Terjadi kesalahan saat menyimpan data.'
            );
        }
    }

    public function edit($id)
    {
        $kursus = KursusModel::findOrFail($id);

        $this->kursusId = $id;
        $this->nama_kursus = $kursus->nama_kursus;
        $this->durasi = $kursus->durasi;
        $this->instruktur_id = $kursus->instruktur_id;
        $this->biaya = $kursus->biaya;

        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function update()
    {
        try {
            $kursus = KursusModel::findOrFail($this->kursusId);
            $kursus->update([
                'nama_kursus' => $this->nama_kursus,
                'durasi' => $this->durasi,
                'instruktur_id' => $this->instruktur_id,
                'biaya' => $this->biaya,
            ]);

            $this->notification()->success(
                $title = 'Berhasil!',
                $description = 'Kursus berhasil diperbarui.'
            );

            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan kursus: ' . $e->getMessage());

            $this->notification()->error(
                $title = 'Error!',
                $description = 'Terjadi kesalahan saat menyimpan data.'
            );
        }
    }

    public function delete($id)
    {
        $this->dialog()->confirm([
            'title'       => 'Apakah Anda yakin?',
            'description' => 'Data kursus akan dihapus permanen.',
            'acceptLabel' => 'Ya, Hapus',
            'method'      => 'deleteConfirmed',
            'params'      => $id,
        ]);
    }

    public function deleteConfirmed($id)
    {
        try {
            KursusModel::findOrFail($id)->delete();

            $this->notification()->success(
                $title = 'Berhasil!',
                $description = 'Kursus berhasil dihapus.'
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                $title = 'Error!',
                $description = 'Terjadi kesalahan saat menghapus data.'
            );
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $kursus = KursusModel::with('user')
            ->when($this->search, function ($query) {
                $query->where('nama_kursus', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest()
            ->paginate(9);
        $instruktur = User::select('id', 'name')->get();

        return view('livewire.kursus', compact('kursus', 'instruktur'));
    }
}

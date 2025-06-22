<?php

namespace App\Livewire;

use App\Models\User as UserModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class User extends Component
{
    // Properties
    public $userList;
    public $name, $email, $password, $role;
    public $userId;
    public $isEdit = false;
    public $showForm = false;

    // Daftar role
    public $roles = ['admin', 'instruktur', 'peserta'];

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $this->userList = UserModel::all(); // Ambil semua user
        return view('livewire.user');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->userId = null;
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
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,instruktur,peserta',
        ]);

        UserModel::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role,
        ]);

        session()->flash('message', 'User berhasil ditambahkan!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->isEdit = true;
        $this->showForm = true;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,instruktur,peserta',
        ]);

        $user = UserModel::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password ? bcrypt($this->password) : $user->password,
            'role' => $this->role,
        ]);

        session()->flash('message', 'User berhasil diperbarui!');
        $this->resetForm();
    }

    public function delete($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        session()->flash('message', 'User berhasil dihapus!');
    }
}

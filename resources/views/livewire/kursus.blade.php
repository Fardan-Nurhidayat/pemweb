<div class="p-6">
    {{-- Header Section --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Management Kursus</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola data kursus yang tersedia</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <x-button primary icon="plus" wire:click="openModal">
                    Tambah Kursus
                </x-button>
            </div>
        </div>
    </div>

    {{-- Search Section --}}
    <div class="mb-6">
        <div class="max-w-md">
            <x-input
                icon="magnifying-glass"
                placeholder="Cari kursus atau instruktur..."
                wire:model.live.debounce.300ms="search" />
        </div>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse($kursus as $item)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                {{-- Header Card --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1 line-clamp-2">
                            {{ $item->nama_kursus }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                            <x-icon name="user" class="w-4 h-4 mr-1" />
                            {{ $item->user->name ?? 'Instruktur tidak ditemukan' }}
                        </p>
                    </div>
                    <div class="flex space-x-1 ml-2">
                        <x-button
                            xs
                            outline
                            positive
                            icon="pencil"
                            wire:click="edit({{ $item->id }})"
                            title="Edit Kursus" />
                        <x-button
                            xs
                            outline
                            negative
                            icon="trash"
                            wire:click="delete({{ $item->id }})"
                            title="Hapus Kursus" />
                    </div>
                </div>

                {{-- Content Card --}}
                <div class="space-y-3">
                    {{-- Durasi --}}
                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <x-icon name="clock" class="w-4 h-4 mr-2 text-blue-500" />
                        <span>{{ $item->durasi }} hari</span>
                    </div>

                    {{-- Biaya --}}
                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <x-icon name="currency-dollar" class="w-4 h-4 mr-2 text-green-500" />
                        <span class="font-medium text-green-600 dark:text-green-400">
                            Rp {{ number_format($item->biaya, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Tanggal dibuat --}}
                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-500">
                        <x-icon name="calendar" class="w-3 h-3 mr-1" />
                        <span>Dibuat: {{ $item->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <x-icon name="academic-cap" class="w-16 h-16 mx-auto text-gray-400 mb-4" />
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    Belum ada kursus
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    @if($search)
                    Tidak ada kursus yang ditemukan dengan kata kunci "{{ $search }}"
                    @else
                    Mulai dengan menambahkan kursus pertama Anda
                    @endif
                </p>
                @if($search)
                <x-button outline wire:click="$set('search', '')">
                    Hapus Filter
                </x-button>
                @else
                <x-button primary icon="plus" wire:click="openModal">
                    Tambah Kursus
                </x-button>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($kursus->hasPages())
    <div class="mt-6">
        {{ $kursus->links() }}
    </div>
    @endif

    {{-- Modal Form --}}
    <x-modal wire:model.defer="isOpen" max-width="lg">
        <x-card title="{{ $isEdit ? 'Edit Kursus' : 'Tambah Kursus' }}">
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                <div class="space-y-4">
                    {{-- Nama Kursus --}}
                    <div>
                        <x-input
                            label="Nama Kursus"
                            placeholder="Masukkan nama kursus"
                            wire:model="nama_kursus"
                            required />
                    </div>

                    {{-- Instruktur --}}
                    <div>
                        <x-select
                            label="Instruktur"
                            placeholder="Pilih instruktur"
                            wire:model="instruktur_id"
                            :options="$instruktur"
                            option-label="name"
                            option-value="id"
                            required />
                    </div>

                    {{-- Durasi dan Biaya --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input
                                label="Durasi (hari)"
                                placeholder="30"
                                wire:model="durasi"
                                type="number"
                                min="1"
                                required />
                        </div>
                        <div>
                            <x-input
                                label="Biaya"
                                placeholder="500000"
                                wire:model="biaya"
                                type="number"
                                min="0"
                                step="1000"
                                required />
                        </div>
                    </div>
                </div>

                <x-slot name="footer">
                    <div class="flex justify-end space-x-2">
                        <x-button flat label="Batal" wire:click="closeModal" />
                        <x-button
                            primary
                            type="submit"
                            :label="$isEdit ? 'Update' : 'Simpan'"
                            spinner="{{ $isEdit ? 'update' : 'store' }}" />
                    </div>
                </x-slot>
            </form>
        </x-card>
    </x-modal>
</div>
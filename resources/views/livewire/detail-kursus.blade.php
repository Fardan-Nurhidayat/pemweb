<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Back Button -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <button wire:click="kembali"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </button>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Kursus</h1>
                <p class="text-gray-600">Informasi lengkap tentang kursus yang dipilih</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="text-green-800 font-medium">{{ session('message') }}</span>
        </div>
        @endif

        <!-- Modal Daftar Materi -->
        @if($showMateriModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-5xl w-full mx-4 max-h-[80vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-white">Daftar Materi - {{ $kursus->nama_kursus }}</h3>
                        <button wire:click="toggleMateriModal" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[60vh]">
                    @if(count($materiList) > 0)
                    <div class="space-y-4">
                        @foreach($materiList as $index => $materi)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-3">
                                            <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full text-sm font-semibold mr-3">
                                                {{ $materi->urutan ?? ($index + 1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $materi->judul }}</h4>
                                                <p class="text-sm text-gray-500">Materi {{ $materi->urutan ?? ($index + 1) }}</p>
                                            </div>
                                        </div>

                                        @if($materi->deskripsi)
                                        <p class="text-gray-700 mb-4 leading-relaxed">{{ $materi->deskripsi }}</p>
                                        @endif

                                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                            @if($materi->durasi)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>{{ $materi->durasi }} menit</span>
                                            </div>
                                            @endif

                                            @if($materi->tipe)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4zM6 6v12h12V6H6zm3 3a1 1 0 112 0v6a1 1 0 11-2 0V9zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V9z"></path>
                                                </svg>
                                                <span class="capitalize">{{ $materi->tipe }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="ml-4">
                                       
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Aktif
                                        </span>
                                    </div>
                                </div>

                                <!-- Link atau File -->
                                @if($materi->link || $materi->file_path)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-700">Resource:</span>
                                        <div class="flex gap-2">
                                            @if($materi->link)
                                            <a href="{{ $materi->link }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                                Link
                                            </a>
                                            @endif
                                            @if($materi->file_path)
                                            <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-md transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                File
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada materi</h3>
                        <p class="text-gray-600">Kursus ini belum memiliki materi pembelajaran</p>
                    </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Total {{ count($materiList) }} materi pembelajaran
                        </div>
                        <button wire:click="toggleMateriModal"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-center">
            <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
        @endif

        <!-- Course Detail Card -->
        @if($kursus)
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white">{{ $kursus->nama_kursus }}</h2>
                @if($isRegistered)
                <span class="inline-block mt-2 px-3 py-1 bg-green-500 text-white text-sm font-semibold rounded-full">
                    ✓ Terdaftar
                </span>
                @endif
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Course Info -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kursus</h3>

                        <!-- Duration -->
                        <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Durasi Kursus</p>
                                <p class="text-xl font-bold text-gray-900">{{ $kursus->durasi }} jam</p>
                            </div>
                        </div>

                        <!-- Instructor -->
                        <div class="flex items-center p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Instruktur</p>
                                <p class="text-xl font-bold text-gray-900">{{ $kursus->user->name ?? 'Tidak ada instruktur' }}</p>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                            <div class="flex items-center justify-center w-12 h-12 bg-yellow-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Biaya Kursus</p>
                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($kursus->biaya, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Participants Count -->
                        <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-500 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Peserta</p>
                                <p class="text-xl font-bold text-gray-900">{{ count($pesertaList) }} orang</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Actions -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Aksi</h3>

                        @if(Auth::user()->role == "peserta")
                        @if($canRegister)
                        <button wire:click="daftar"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Daftar Kursus
                        </button>
                        @elseif($isRegistered)
                        <div class="space-y-4">
                            <div class="w-full p-4 bg-green-50 border border-green-200 rounded-lg text-center">
                                <svg class="w-12 h-12 mx-auto text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="text-green-800 font-semibold">Anda sudah terdaftar di kursus ini</p>
                            </div>
                            <button wire:click="batalDaftar"
                                class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batalkan Pendaftaran
                            </button>
                        </div>
                        @endif

                        <!-- Tombol Lihat Materi untuk semua role -->
                        <button wire:click="toggleMateriModal"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            Lihat Materi Kursus ({{ count($materiList) }})
                        </button>
                        @endif

                        @if(Auth::user()->role == "admin" || Auth::user()->role == "instruktur")
                        <div class="space-y-4">
                            <button wire:click="togglePesertaModal"
                                class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Lihat Daftar Peserta ({{ count($pesertaList) }})
                            </button>

                            <button wire:click="toggleMateriModal"
                                class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Lihat Daftar Materi ({{ count($materiList) }})
                            </button>
                        </div>
                        @endif

                        <!-- Course Description Area -->
                        <div class="p-6 bg-gray-50 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Tentang Kursus</h4>
                            <p class="text-gray-600 leading-relaxed">
                                Kursus {{ $kursus->nama_kursus }} ini dirancang untuk memberikan pembelajaran yang komprehensif
                                dengan durasi {{ $kursus->durasi }} jam. Kursus ini dibimbing oleh instruktur berpengalaman
                                dan tersedia dengan biaya yang terjangkau.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Modal Daftar Peserta -->
        @if($showPesertaModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full mx-4 max-h-[80vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-white">Daftar Peserta - {{ $kursus->nama_kursus }}</h3>
                        <button wire:click="togglePesertaModal" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[60vh]">
                    @if(count($pesertaList) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peserta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                    @if(Auth::user()->role == "admin")
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pesertaList as $index => $pendaftaran)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                    <span class="text-white font-semibold">{{ substr($pendaftaran->user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $pendaftaran->user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pendaftaran->user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d M Y') }}
                                    </td>
                                    @if(Auth::user()->role == "admin")
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="hapusPeserta({{ $pendaftaran->id }})"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada peserta</h3>
                        <p class="text-gray-600">Kursus ini belum memiliki peserta yang terdaftar</p>
                    </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4">
                    <button wire:click="togglePesertaModal"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-200">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
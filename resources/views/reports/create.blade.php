@extends('layouts.public')
@section('title', 'Laporkan Insiden K3')

@section('content')
<div class="animate-fade-in-up">
    {{-- LMRA Section --}}
    <div class="mb-8 rounded-2xl border border-gray-200 bg-white overflow-hidden">
        {{-- LMRA Header --}}
        <div class="px-5 pt-5 pb-2 text-center w-full">
            <h2 class="text-xl font-extrabold text-gray-900">LMRA</h2>
            <p class="text-sm font-normal italic text-gray-600 mt-0.5">(Last Minute Risk Assessment)</p>
        </div>
        {{-- LMRA Body --}}
        <div class="px-5 pb-5 pt-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- STOP --}}
            <div class="rounded-xl bg-white border border-red-200 p-4">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: var(--cabot-red);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest" style="color: var(--cabot-red);">Langkah 1</p>
                        <p class="text-base font-extrabold text-gray-900">STOP</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mb-2">Berhenti sejenak sebelum mulai bekerja:</p>
                <ul class="space-y-1.5">
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0 mt-1.5"></span>Hentikan semua aktivitas sejenak (1–5 menit)</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0 mt-1.5"></span>Jangan terburu-buru memulai pekerjaan</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0 mt-1.5"></span>Perhatikan kondisi sekitar dengan seksama</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-red-400 shrink-0 mt-1.5"></span>Jika ragu atau merasa tidak aman — BERHENTI</li>
                </ul>
            </div>
            {{-- THINK --}}
            <div class="rounded-xl bg-white border border-blue-200 p-4">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Langkah 2</p>
                        <p class="text-base font-extrabold text-gray-900">THINK</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mb-2">Evaluasi situasi dan identifikasi bahaya:</p>
                <ul class="space-y-1.5">
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></span>Apakah ada bahaya baru yang belum diperhitungkan?</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></span>Apakah izin kerja (PTW) sudah valid dan sesuai?</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></span>Apakah APD yang digunakan sudah sesuai tugas?</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></span>Apakah peralatan dalam kondisi baik dan aman?</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0 mt-1.5"></span>Apakah prosedur darurat (kebakaran, dll) sudah dipahami?</li>
                </ul>
            </div>
            {{-- ACT --}}
            <div class="rounded-xl bg-white border border-green-200 p-4">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Langkah 3</p>
                        <p class="text-base font-extrabold text-gray-900">ACT</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mb-2">Ambil tindakan yang tepat:</p>
                <ul class="space-y-1.5">
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0 mt-1.5"></span>Jika aman → lanjutkan pekerjaan dengan percaya diri</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0 mt-1.5"></span>Jika ada bahaya → kendalikan risiko terlebih dahulu</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0 mt-1.5"></span>Laporkan kondisi tidak aman kepada pengawas</li>
                    <li class="flex items-start gap-2 text-xs text-gray-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0 mt-1.5"></span>Jika tidak yakin → jangan mulai, konsultasikan dulu</li>
                </ul>
            </div>
        </div>

    </div>
    {{-- Hero Title --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">
            {{ __('Laporkan') }} <span style="color: var(--cabot-red);">{{ __('Insiden K3') }}</span>
        </h1>
        <p class="text-gray-500 max-w-xl mx-auto text-sm sm:text-base">
            {{ __('Keselamatan adalah tanggung jawab bersama. Laporkan segala kejadian, kondisi tidak aman, atau near miss di area kerja PT Cabot.') }}
        </p>
    </div>
    {{-- Form --}}
    <form method="POST" action="{{ route('report.store') }}" enctype="multipart/form-data" class="card-elevated p-6 sm:p-8 space-y-8" id="reportForm">
        @csrf

        {{-- Section: Jenis Kejadian --}}
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-900">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    {{ __('Jenis Kejadian') }} <span class="text-red-500">*</span>
                </span>
            </label>
            <select name="incident_type" class="form-input w-full px-4 py-3 text-sm" required>
                <option value="">— {{ __('Pilih Jenis Kejadian') }} —</option>
                <option value="near_miss" {{ old('incident_type') === 'near_miss' ? 'selected' : '' }}>{{ __('Near Miss (Hampir terjadi kecelakaan)') }}</option>
                <option value="unsafe_act" {{ old('incident_type') === 'unsafe_act' ? 'selected' : '' }}>{{ __('Unsafe Act (Perilaku tidak aman)') }}</option>
                <option value="unsafe_condition" {{ old('incident_type') === 'unsafe_condition' ? 'selected' : '' }}>{{ __('Unsafe Condition (Kondisi area tidak aman)') }}</option>
                <option value="kecelakaan_ringan" {{ old('incident_type') === 'kecelakaan_ringan' ? 'selected' : '' }}>{{ __('Kecelakaan Ringan (Cedera minor/P3K)') }}</option>
                <option value="kecelakaan_berat" {{ old('incident_type') === 'kecelakaan_berat' ? 'selected' : '' }}>{{ __('Kecelakaan Berat (Cedera serius/rawat inap)') }}</option>
                <option value="kebakaran" {{ old('incident_type') === 'kebakaran' ? 'selected' : '' }}>{{ __('Kebakaran (Api/asap/ledakan)') }}</option>
                <option value="tumpahan_kimia" {{ old('incident_type') === 'tumpahan_kimia' ? 'selected' : '' }}>{{ __('Tumpahan Kimia (Tumpahan bahan berbahaya)') }}</option>
                <option value="lainnya" {{ old('incident_type') === 'lainnya' ? 'selected' : '' }}>{{ __('Lainnya') }}</option>
            </select>
            @error('incident_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Section: Lokasi & Urgensi --}}
        <div class="grid sm:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ __('Lokasi Kejadian') }} <span class="text-red-500">*</span>
                    </span>
                </label>
                <select name="location" class="form-input w-full px-4 py-3 text-sm" required>
                    <option value="">— {{ __('Pilih Lokasi') }} —</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc }}" {{ old('location') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                    @endforeach
                </select>
                @error('location')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        {{ __('Tingkat Urgensi') }} <span class="text-red-500">*</span>
                    </span>
                </label>
                <div class="grid grid-cols-4 gap-2">
                    <label class="cursor-pointer urgency-option">
                        <input type="radio" name="urgency" value="rendah" class="sr-only" {{ old('urgency') === 'rendah' ? 'checked' : '' }} required>
                        <div class="urgency-label-rendah p-2.5 rounded-lg border border-gray-200 bg-white text-center transition-all duration-300 hover:bg-gray-50">
                            <div class="w-3 h-3 rounded-full bg-emerald-500 mx-auto mb-1"></div>
                            <span class="text-xs font-medium text-gray-700">{{ __('Rendah') }}</span>
                        </div>
                    </label>
                    <label class="cursor-pointer urgency-option">
                        <input type="radio" name="urgency" value="sedang" class="sr-only" {{ old('urgency') === 'sedang' ? 'checked' : '' }} required>
                        <div class="urgency-label-sedang p-2.5 rounded-lg border border-gray-200 bg-white text-center transition-all duration-300 hover:bg-gray-50">
                            <div class="w-3 h-3 rounded-full bg-amber-500 mx-auto mb-1"></div>
                            <span class="text-xs font-medium text-gray-700">{{ __('Sedang') }}</span>
                        </div>
                    </label>
                    <label class="cursor-pointer urgency-option">
                        <input type="radio" name="urgency" value="tinggi" class="sr-only" {{ old('urgency') === 'tinggi' ? 'checked' : '' }} required>
                        <div class="urgency-label-tinggi p-2.5 rounded-lg border border-gray-200 bg-white text-center transition-all duration-300 hover:bg-gray-50">
                            <div class="w-3 h-3 rounded-full bg-orange-500 mx-auto mb-1"></div>
                            <span class="text-xs font-medium text-gray-700">{{ __('Tinggi') }}</span>
                        </div>
                    </label>
                    <label class="cursor-pointer urgency-option">
                        <input type="radio" name="urgency" value="kritis" class="sr-only" {{ old('urgency') === 'kritis' ? 'checked' : '' }} required>
                        <div class="urgency-label-kritis p-2.5 rounded-lg border border-gray-200 bg-white text-center transition-all duration-300 hover:bg-gray-50">
                            <div class="w-3 h-3 rounded-full bg-red-600 mx-auto mb-1"></div>
                            <span class="text-xs font-medium text-gray-700">{{ __('Kritis') }}</span>
                        </div>
                    </label>
                </div>
                @error('urgency')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Section: Tanggal & Waktu --}}
        <div class="grid sm:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ __('Tanggal Kejadian') }} <span class="text-red-500">*</span>
                    </span>
                </label>
                <input type="date" name="incident_date" value="{{ old('incident_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="form-input w-full px-4 py-3 text-sm" required>
                @error('incident_date')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Waktu Kejadian') }} <span class="text-gray-400">({{ __('opsional') }})</span>
                    </span>
                </label>
                <input type="time" name="incident_time" value="{{ old('incident_time') }}" class="form-input w-full px-4 py-3 text-sm">
            </div>
        </div>

        {{-- Section: Deskripsi --}}
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-900">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    {{ __('Deskripsi Kejadian') }} <span class="text-red-500">*</span>
                </span>
            </label>
            <textarea name="description" rows="4" placeholder="{{ __('Jelaskan detail kejadian: apa yang terjadi, siapa yang terlibat, bagaimana kronologinya...') }}" class="form-input w-full px-4 py-3 text-sm resize-none" required minlength="10">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        {{-- Section: Upload Foto --}}
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-900">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ __('Foto Bukti') }} <span class="text-gray-400">({{ __('opsional, maks 5MB') }})</span>
                </span>
            </label>
            <div class="relative" id="dropZone">
                <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="photoInput">
                <div class="border-2 border-dashed border-gray-300 hover:border-red-300 rounded-xl p-8 text-center transition-all duration-300" id="dropZoneInner">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-sm text-gray-500" id="dropText">{{ __('Klik atau seret foto ke sini') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ __('JPG, PNG — Maksimal 5MB') }}</p>
                </div>
            </div>
            <div id="photoPreview" class="hidden mt-3">
                <img src="" alt="Preview" class="max-h-40 rounded-lg border border-gray-200" id="previewImage">
                <button type="button" onclick="clearPhoto()" class="text-xs text-red-500 hover:text-red-700 mt-2">✕ {{ __('Hapus foto') }}</button>
            </div>
            @error('photo')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        {{-- Section: Informasi Pelapor --}}
        <div class="card p-5 space-y-4">
            <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4" style="color: var(--cabot-red);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ __('Informasi Pelapor') }}
            </h3>
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">{{ __('Nama Lengkap') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" placeholder="{{ __('Masukkan nama Anda') }}" class="form-input w-full px-4 py-3 text-sm" id="reporterName">
                    @error('reporter_name')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">{{ __('Departemen') }}</label>
                        <input type="text" name="reporter_department" value="{{ old('reporter_department') }}" placeholder="{{ __('Contoh: Produksi') }}" class="form-input w-full px-4 py-3 text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">{{ __('No. Telepon') }}</label>
                        <input type="text" name="reporter_phone" value="{{ old('reporter_phone') }}" placeholder="08xxxxxxxxxx" class="form-input w-full px-4 py-3 text-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="pt-2">
            <button type="submit" class="btn-primary w-full py-4 text-sm tracking-wide">
                <svg class="w-5 h-5 inline mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                {{ __('Kirim Laporan Insiden') }}
            </button>
            <p class="text-xs text-center text-gray-400 mt-3">{{ __('Laporan Anda akan langsung diteruskan ke tim SHE PT Cabot.') }}</p>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Photo preview
    const photoInput = document.getElementById('photoInput');
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('photoPreview').classList.remove('hidden');
                document.getElementById('dropText').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    });

    function clearPhoto() {
        document.getElementById('photoInput').value = '';
        document.getElementById('photoPreview').classList.add('hidden');
        document.getElementById('dropText').textContent = 'Klik atau seret foto ke sini';
    }

</script>
@endpush

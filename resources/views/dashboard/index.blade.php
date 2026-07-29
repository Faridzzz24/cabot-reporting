@extends('layouts.dashboard')
@section('title', 'Dashboard SHE')
@section('page-title', 'Dashboard')

@section('content')
{{-- KPI Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="kpi-card p-5 animate-fade-in-up" style="animation-delay: 0.05s">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-medium text-gray-900 animate-count">{{ $kpi['total'] }}</p>
        <p class="text-xs font-medium text-gray-500 mt-1 uppercase tracking-wide">{{ __('Total Laporan') }}</p>
    </div>

    <div class="kpi-card p-5 animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-medium text-amber-600 animate-count">{{ $kpi['baru'] }}</p>
        <p class="text-xs font-medium text-gray-500 mt-1 uppercase tracking-wide">{{ __('Belum Ditangani') }}</p>
    </div>

    <div class="kpi-card p-5 animate-fade-in-up" style="animation-delay: 0.15s">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </div>
        </div>
        <p class="text-3xl font-medium text-purple-600 animate-count">{{ $kpi['dalam_proses'] }}</p>
        <p class="text-xs font-medium text-gray-500 mt-1 uppercase tracking-wide">{{ __('Dalam Proses') }}</p>
    </div>

    <div class="kpi-card p-5 animate-fade-in-up" style="animation-delay: 0.2s">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-medium text-emerald-600 animate-count">{{ $kpi['selesai'] }}</p>
        <p class="text-xs font-medium text-gray-500 mt-1 uppercase tracking-wide">{{ __('Selesai') }}</p>
    </div>

    <div class="kpi-card p-5 animate-fade-in-up col-span-2 lg:col-span-1 {{ $kpi['kritis'] > 0 ? 'border-red-200 bg-red-50/50' : '' }}" style="animation-delay: 0.25s">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-medium text-red-600 animate-count">{{ $kpi['kritis'] }}</p>
        <p class="text-xs font-medium text-gray-500 mt-1 uppercase tracking-wide">{{ __('Kritis Aktif') }}</p>
    </div>
</div>

{{-- Monthly Trend --}}
<div class="glass-card p-4 sm:p-5 mb-5 animate-fade-in-up" style="animation-delay: 0.3s">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <h3 class="text-sm font-semibold text-gray-900">
            {{ __('Tren Laporan') }} 
            <span class="text-gray-500 font-normal">
                ({{ \Carbon\Carbon::create()->month(request('trend_start', 1))->translatedFormat('F') }} - 
                {{ \Carbon\Carbon::create()->month(request('trend_end', 6))->translatedFormat('F') }} 
                {{ request('trend_year', now()->year) }})
            </span>
        </h3>
        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-2">
            @foreach(request()->except(['trend_year', 'trend_start', 'trend_end']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <select name="trend_start" class="form-input-dash px-2 py-1 text-xs">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('trend_start', 1) == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('M') }}</option>
                @endfor
            </select>
            <span class="text-gray-400 text-xs">-</span>
            <select name="trend_end" class="form-input-dash px-2 py-1 text-xs">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ request('trend_end', 6) == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('M') }}</option>
                @endfor
            </select>
            <select name="trend_year" class="form-input-dash px-2 py-1 text-xs ml-1">
                @php $currentYear = now()->year; @endphp
                @for($y = $currentYear - 2; $y <= $currentYear + 1; $y++)
                    <option value="{{ $y }}" {{ request('trend_year', $currentYear) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="px-3 py-1 rounded-md text-white text-xs font-medium transition-all ml-1" style="background: var(--cabot-red); hover:opacity-90;">
                {{ __('Terapkan') }}
            </button>
        </form>
    </div>
    <div class="flex items-end gap-1 sm:gap-3 h-24 sm:h-28 mt-6 overflow-x-auto hide-scrollbar">
        @php 
            $counts = array_column($monthlyTrend, 'count');
            $maxCount = count($counts) > 0 ? max($counts) : 1;
            if ($maxCount == 0) $maxCount = 1;
        @endphp
        @foreach($monthlyTrend as $month)
        <div class="flex-1 min-w-[35px] sm:min-w-0 flex flex-col items-center gap-1 sm:gap-2 relative group cursor-pointer">
            <span class="text-[10px] sm:text-xs font-semibold text-gray-600 transition-colors group-hover:text-cabot-red">{{ $month['count'] }}</span>
            <div class="w-full rounded-t-xl transition-all duration-300 opacity-90 group-hover:opacity-100 group-hover:scale-y-[1.02] origin-bottom shadow-sm"
                 style="height: {{ $maxCount > 0 ? max(($month['count'] / $maxCount) * 100, 4) : 4 }}%; background: linear-gradient(180deg, var(--cabot-red) 0%, var(--cabot-red-dark) 100%);"></div>
            <span class="text-[10px] sm:text-xs font-medium text-gray-400 truncate w-full text-center">{{ $month['month'] }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- Filters --}}
<div class="glass-card p-4 sm:p-5 mb-6 animate-fade-in-up" style="animation-delay: 0.35s">
    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
        <div class="sm:col-span-2 lg:col-span-1">
            <label class="text-xs text-gray-400 mb-1 block">{{ __('Cari') }}</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Kode tracking, deskripsi, lokasi...') }}" class="form-input-dash w-full px-3 py-2 text-sm">
        </div>
        <div>
            <label class="text-xs text-gray-400 mb-1 block">{{ __('Jenis') }}</label>
            <select name="type" class="form-input-dash w-full px-3 py-2 text-sm">
                <option value="">{{ __('Semua') }}</option>
                <option value="near_miss" {{ request('type') === 'near_miss' ? 'selected' : '' }}>{{ __('Near Miss (Hampir terjadi kecelakaan)') }}</option>
                <option value="unsafe_act" {{ request('type') === 'unsafe_act' ? 'selected' : '' }}>{{ __('Unsafe Act (Perilaku tidak aman)') }}</option>
                <option value="unsafe_condition" {{ request('type') === 'unsafe_condition' ? 'selected' : '' }}>{{ __('Unsafe Condition (Kondisi area tidak aman)') }}</option>
                <option value="kecelakaan_ringan" {{ request('type') === 'kecelakaan_ringan' ? 'selected' : '' }}>{{ __('Kecelakaan Ringan (Cedera minor/P3K)') }}</option>
                <option value="kecelakaan_berat" {{ request('type') === 'kecelakaan_berat' ? 'selected' : '' }}>{{ __('Kecelakaan Berat (Cedera serius/rawat inap)') }}</option>
                <option value="kebakaran" {{ request('type') === 'kebakaran' ? 'selected' : '' }}>{{ __('Kebakaran (Api/asap/ledakan)') }}</option>
                <option value="tumpahan_kimia" {{ request('type') === 'tumpahan_kimia' ? 'selected' : '' }}>{{ __('Tumpahan Kimia (Tumpahan bahan berbahaya)') }}</option>
                <option value="lainnya" {{ request('type') === 'lainnya' ? 'selected' : '' }}>{{ __('Lainnya') }}</option>
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-400 mb-1 block">{{ __('Urgensi') }}</label>
            <select name="urgency" class="form-input-dash w-full px-3 py-2 text-sm">
                <option value="">{{ __('Semua') }}</option>
                <option value="rendah" {{ request('urgency') === 'rendah' ? 'selected' : '' }}>{{ __('Rendah') }}</option>
                <option value="sedang" {{ request('urgency') === 'sedang' ? 'selected' : '' }}>{{ __('Sedang') }}</option>
                <option value="tinggi" {{ request('urgency') === 'tinggi' ? 'selected' : '' }}>{{ __('Tinggi') }}</option>
                <option value="kritis" {{ request('urgency') === 'kritis' ? 'selected' : '' }}>{{ __('Kritis') }}</option>
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-400 mb-1 block">Status</label>
            <select name="status" class="form-input-dash w-full px-3 py-2 text-sm">
                <option value="">Semua</option>
                <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="ditinjau" {{ request('status') === 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                <option value="dalam_penanganan" {{ request('status') === 'dalam_penanganan' ? 'selected' : '' }}>Dalam Penanganan</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="flex gap-2 sm:col-span-2 lg:col-span-1">
            <button type="submit" class="flex-1 px-4 py-2 rounded-lg text-white text-sm font-medium transition-all duration-300 text-center" style="background: var(--cabot-red);">
                Filter
            </button>
            @if(request()->hasAny(['search', 'type', 'urgency', 'status']))
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium transition-all duration-300 text-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Reports Table --}}
<div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.4s">
    <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-white relative z-10">
        <h3 class="font-semibold text-gray-900">Daftar Laporan</h3>
        <button type="button" id="toggle-select-mode" class="text-xs font-medium text-gray-500 hover:text-cabot-red transition-colors bg-gray-100 hover:bg-red-50 px-3 py-1.5 rounded-md">
            Pilih Laporan
        </button>
    </div>
    <form id="bulk-delete-form" method="POST" action="{{ route('reports.bulkDestroy') }}">
        @csrf
        @method('DELETE')
        
        <div id="bulk-action-bar" class="hidden px-5 py-3 bg-red-50 border-b border-red-100 justify-between items-center">
            <span class="text-sm text-red-800 font-medium"><span id="selected-count">0</span> laporan terpilih</span>
            <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700 transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus semua laporan yang dipilih secara permanen?')">Hapus Terpilih</button>
        </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/70">
                    <th class="checkbox-col hidden px-2 sm:px-5 py-3 sm:py-4 w-10 text-center align-middle">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-red-600 focus:ring-red-500 transition-colors">
                    </th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Kode</th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Jenis</th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Lokasi</th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Urgensi</th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Status</th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Pelapor</th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                    <th class="text-center px-4 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reports as $report)
                <tr class="hover:bg-red-50/40 transition-colors group">
                    <td class="checkbox-col hidden px-4 sm:px-6 py-3 sm:py-4 text-center align-middle">
                        <input type="checkbox" name="ids[]" value="{{ $report->id }}" class="row-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500">
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center whitespace-nowrap">
                        <span class="font-mono text-[10px] sm:text-xs font-medium" style="color: var(--cabot-red);">{{ $report->tracking_code }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center whitespace-nowrap">
                        <span class="text-gray-700 text-[10px] sm:text-xs font-medium">{{ $report->incident_type_label }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center whitespace-nowrap">
                        <span class="text-gray-700 text-[10px] sm:text-xs font-medium" title="{{ $report->location }}">{{ Str::limit($report->location, 20) }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center whitespace-nowrap">
                        <span class="text-[10px] sm:text-xs font-medium whitespace-nowrap
                            {{ $report->urgency === 'rendah' ? 'text-emerald-600' : '' }}
                            {{ $report->urgency === 'sedang' ? 'text-amber-600' : '' }}
                            {{ $report->urgency === 'tinggi' ? 'text-red-600' : '' }}
                            {{ $report->urgency === 'kritis' ? 'text-red-700' : '' }}
                        ">{{ $report->urgency_label }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center whitespace-nowrap">
                        <span class="text-[10px] sm:text-xs font-medium whitespace-nowrap
                            {{ $report->status === 'baru' ? 'text-blue-600' : '' }}
                            {{ $report->status === 'ditinjau' ? 'text-purple-600' : '' }}
                            {{ $report->status === 'dalam_penanganan' ? 'text-indigo-600' : '' }}
                            {{ $report->status === 'selesai' ? 'text-emerald-600' : '' }}
                            {{ $report->status === 'ditolak' ? 'text-red-600' : '' }}
                        ">{{ $report->status_label }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-gray-700 text-[10px] sm:text-xs font-medium">{{ $report->reporter_name }}</span>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center align-middle whitespace-nowrap">
                        <span class="text-gray-700 text-[10px] sm:text-xs font-medium">{{ $report->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-3 sm:py-4 text-center align-middle whitespace-nowrap">
                        <a href="{{ route('reports.show', $report->id) }}" class="inline-block text-[10px] sm:text-xs font-medium whitespace-nowrap hover:opacity-80 transition-opacity" style="color: var(--cabot-red);">
                            Lihat →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-5 py-12 text-center">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="text-sm text-gray-400">Belum ada laporan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reports->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $reports->links() }}
    </div>
    @endif
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkActionBar = document.getElementById('bulk-action-bar');
        const selectedCountSpan = document.getElementById('selected-count');
        const toggleSelectModeBtn = document.getElementById('toggle-select-mode');
        const checkboxCols = document.querySelectorAll('.checkbox-col');

        if(toggleSelectModeBtn) {
            toggleSelectModeBtn.addEventListener('click', function() {
                checkboxCols.forEach(col => col.classList.toggle('hidden'));
                
                if(checkboxCols.length > 0 && checkboxCols[0].classList.contains('hidden')) {
                    toggleSelectModeBtn.textContent = 'Pilih Laporan';
                    toggleSelectModeBtn.classList.remove('bg-red-50', 'text-cabot-red');
                    toggleSelectModeBtn.classList.add('bg-gray-100', 'text-gray-500');
                    if(selectAll) selectAll.checked = false;
                    rowCheckboxes.forEach(cb => cb.checked = false);
                    updateBulkActions();
                } else {
                    toggleSelectModeBtn.textContent = 'Batal Pilih';
                    toggleSelectModeBtn.classList.add('bg-red-50', 'text-cabot-red');
                    toggleSelectModeBtn.classList.remove('bg-gray-100', 'text-gray-500');
                }
            });
        }

        if(selectAll && rowCheckboxes.length > 0) {
            selectAll.addEventListener('change', function(e) {
                rowCheckboxes.forEach(cb => cb.checked = e.target.checked);
                updateBulkActions();
            });

            rowCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateBulkActions);
            });
        }

        function updateBulkActions() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            selectedCountSpan.textContent = checkedCount;
            
            if (checkedCount > 0) {
                bulkActionBar.classList.remove('hidden');
                bulkActionBar.classList.add('flex');
            } else {
                bulkActionBar.classList.add('hidden');
                bulkActionBar.classList.remove('flex');
                if(selectAll) selectAll.checked = false;
            }
        }
    });
</script>
@endsection

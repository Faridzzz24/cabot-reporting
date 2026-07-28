@extends('layouts.dashboard')
@section('title', 'Detail Laporan ' . $report->tracking_code)
@section('page-title', 'Detail Laporan')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Dashboard
    </a>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Header --}}
            <div class="glass-card p-6 animate-fade-in-up">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                    <div>
                        <p class="text-xs text-gray-400 font-mono tracking-wider mb-1">{{ $report->tracking_code }}</p>
                        <h2 class="text-xl font-bold text-gray-900">{{ $report->incident_type_label }}</h2>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                            {{ $report->urgency === 'rendah' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $report->urgency === 'sedang' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $report->urgency === 'tinggi' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $report->urgency === 'kritis' ? 'bg-red-100 text-red-700' : '' }}
                        ">{{ $report->urgency_label }}</span>
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                            {{ $report->status === 'baru' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $report->status === 'ditinjau' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $report->status === 'dalam_penanganan' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $report->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $report->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                        ">{{ $report->status_label }}</span>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-3">
                        <div><p class="text-xs text-gray-400 mb-0.5">Lokasi</p><p class="text-gray-800">{{ $report->location }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Tanggal Kejadian</p><p class="text-gray-800">{{ $report->incident_date->format('d M Y') }} {{ $report->incident_time ? '— ' . $report->incident_time : '' }}</p></div>
                        <div><p class="text-xs text-gray-400 mb-0.5">Dilaporkan</p><p class="text-gray-800">{{ $report->created_at->format('d M Y, H:i') }} ({{ $report->created_at->diffForHumans() }})</p></div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Pelapor</p>
                        <p class="text-sm font-medium text-gray-900">{{ $report->reporter_name }}</p>
                        @if($report->reporter_department)
                            <p class="text-xs text-gray-500">{{ $report->reporter_department }}</p>
                        @endif
                        @if($report->reporter_phone)
                            <p class="text-xs text-gray-500">{{ $report->reporter_phone }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="glass-card p-6 animate-fade-in-up" style="animation-delay: 0.1s">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Deskripsi Kejadian</h3>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $report->description }}</p>
            </div>

            @if($report->photo_data)
            <div class="glass-card p-6 animate-fade-in-up" style="animation-delay: 0.15s">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Foto Bukti</h3>
                <img src="{{ route('photo.serve', $report->id) }}" alt="Foto bukti insiden" class="rounded-xl max-h-96 w-auto border border-gray-200">
            </div>
            @endif

            @if($report->resolution_notes)
            <div class="glass-card p-6 animate-fade-in-up" style="animation-delay: 0.2s">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Catatan Resolusi</h3>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $report->resolution_notes }}</p>
                @if($report->resolved_at)
                <p class="text-xs text-gray-400 mt-2">Diselesaikan: {{ $report->resolved_at->format('d M Y, H:i') }}</p>
                @endif
            </div>
            @endif

            {{-- ════════════════════════════════════════════════════════════ --}}
            {{-- RCA Section — AI Generated Root Cause Analysis             --}}
            {{-- ════════════════════════════════════════════════════════════ --}}
            <div id="rca-section" class="animate-fade-in-up" style="animation-delay: 0.22s">
                {{-- RCA Results (shown when rca_data exists or after generate) --}}
                <div id="rca-results" class="{{ $report->rca_data ? '' : 'hidden' }}">
                    <div class="glass-card overflow-hidden">
                        {{-- RCA Header --}}
                        <div class="px-6 pt-6 pb-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900">Root Cause Analysis (RCA)</h3>
                                        <p class="text-xs text-gray-400" id="rca-timestamp">
                                            @if($report->rca_generated_at)
                                                Generated {{ $report->rca_generated_at->diffForHumans() }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span id="rca-status-badge" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $report->rca_data && ($report->rca_data['meta']['status'] ?? 'draft') === 'reviewed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $report->rca_data && ($report->rca_data['meta']['status'] ?? 'draft') === 'reviewed' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                        {{ $report->rca_data && ($report->rca_data['meta']['status'] ?? 'draft') === 'reviewed' ? 'Reviewed' : 'Draft AI' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- RCA Content --}}
                        <div class="p-6 space-y-5">
                            {{-- Ringkasan --}}
                            <div id="rca-ringkasan-section" class="{{ $report->rca_data && isset($report->rca_data['ringkasan']) ? '' : 'hidden' }}">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Ringkasan</p>
                                <p id="rca-ringkasan" class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4">{{ $report->rca_data['ringkasan'] ?? '' }}</p>
                            </div>

                            {{-- Akar Masalah --}}
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Kemungkinan Akar Masalah</p>
                                <div id="rca-akar-masalah" class="space-y-2">
                                    @if($report->rca_data && isset($report->rca_data['akar_masalah']))
                                        @foreach($report->rca_data['akar_masalah'] as $idx => $item)
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-red-50/50 border border-red-100/50">
                                            <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-red-100 text-red-600 text-xs font-bold flex items-center justify-center mt-0.5">{{ $idx + 1 }}</span>
                                            <p class="text-sm text-gray-700">{{ $item }}</p>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Kategori Fishbone --}}
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Analisis Fishbone (Ishikawa)</p>
                                <div id="rca-kategori" class="grid sm:grid-cols-2 gap-3">
                                    @if($report->rca_data && isset($report->rca_data['kategori']))
                                        @php $icons = [
                                            'manusia' => ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'blue'],
                                            'proses' => ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'color' => 'purple'],
                                            'peralatan' => ['icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'orange'],
                                            'lingkungan' => ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald'],
                                        ]; @endphp
                                        @foreach($report->rca_data['kategori'] as $kat => $analisis)
                                        @php $style = $icons[$kat] ?? ['icon' => '', 'color' => 'gray']; @endphp
                                        <div class="p-4 rounded-xl bg-{{ $style['color'] }}-50/50 border border-{{ $style['color'] }}-100/50">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-4 h-4 text-{{ $style['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon'] }}"/>
                                                </svg>
                                                <p class="text-xs font-bold text-{{ $style['color'] }}-700 uppercase">{{ ucfirst($kat) }}</p>
                                            </div>
                                            <p class="text-sm text-gray-600 leading-relaxed">{{ $analisis }}</p>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Rekomendasi --}}
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Rekomendasi Tindakan Korektif</p>
                                <div id="rca-rekomendasi" class="space-y-2">
                                    @if($report->rca_data && isset($report->rca_data['rekomendasi']))
                                        @foreach($report->rca_data['rekomendasi'] as $idx => $item)
                                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/50 border border-emerald-100/50">
                                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-sm text-gray-700">{{ $item }}</p>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Meta info --}}
                            @if($report->rca_data && isset($report->rca_data['meta']))
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-400 italic">
                                    {{ $report->rca_data['meta']['catatan'] ?? 'Draft AI-generated — perlu review HSE Officer.' }}
                                    @if(isset($report->rca_data['meta']['reviewed_by']))
                                        <br>Direview oleh: {{ $report->rca_data['meta']['reviewed_by'] }}
                                        @if(isset($report->rca_data['meta']['reviewed_at']))
                                            ({{ \Carbon\Carbon::parse($report->rca_data['meta']['reviewed_at'])->format('d M Y, H:i') }})
                                        @endif
                                    @endif
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RCA Loading State --}}
                <div id="rca-loading" class="hidden">
                    <div class="glass-card p-8">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <div class="relative">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);">
                                    <svg class="w-7 h-7 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div class="absolute -inset-2 rounded-2xl opacity-20 animate-ping" style="background: linear-gradient(135deg, #ef4444, #f97316);"></div>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-semibold text-gray-900">AI sedang menganalisis...</p>
                                <p class="text-xs text-gray-400 mt-1">Menggunakan metode 5-Why & Fishbone untuk identifikasi akar masalah</p>
                            </div>
                            <div class="flex gap-1 mt-1">
                                <span class="w-2 h-2 rounded-full bg-red-400 animate-bounce" style="animation-delay: 0s;"></span>
                                <span class="w-2 h-2 rounded-full bg-orange-400 animate-bounce" style="animation-delay: 0.15s;"></span>
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 0.3s;"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RCA Error State --}}
                <div id="rca-error" class="hidden">
                    <div class="glass-card p-6 border-red-200">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-red-800">Gagal Generate RCA</p>
                                <p id="rca-error-message" class="text-xs text-red-600 mt-1"></p>
                                <button onclick="generateRca()" class="mt-3 text-xs font-medium text-red-600 hover:text-red-800 underline underline-offset-2">
                                    Coba Lagi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Audit Trail --}}
            <div class="glass-card p-6 animate-fade-in-up" style="animation-delay: 0.25s">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Audit Trail</h3>
                <div class="space-y-3">
                    @forelse($report->auditLogs->sortByDesc('created_at') as $log)
                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 text-xs font-medium text-gray-500 mt-0.5">
                            {{ strtoupper(substr($log->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-gray-700"><span class="font-medium text-gray-900">{{ $log->user->name }}</span> — {{ $log->action_label }}</p>
                            @if($log->details)
                            <p class="text-xs text-gray-400 mt-0.5">
                                @if($log->action === 'status_changed') {{ $log->details['from'] ?? '' }} → {{ $log->details['to'] ?? '' }}
                                @elseif($log->action === 'assigned') Ditugaskan ke: {{ $log->details['assigned_to_name'] ?? '' }}
                                @elseif($log->action === 'rca_generated') Model: {{ $log->details['model'] ?? '' }}
                                @elseif($log->action === 'rca_saved') Direview oleh: {{ $log->details['reviewed_by'] ?? '' }}
                                @endif
                            </p>
                            @endif
                            <p class="text-xs text-gray-300 mt-0.5">{{ $log->created_at->format('d/m/Y H:i') }} • {{ $log->ip_address }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400">Belum ada aktivitas tercatat.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar Actions --}}
        <div class="space-y-6">
            {{-- ══ Generate RCA Button ══ --}}
            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.05s">
                <div class="p-5">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">AI Root Cause Analysis</h3>
                            <p class="text-xs text-gray-400">Analisis otomatis dengan AI</p>
                        </div>
                    </div>
                    <button
                        id="btn-generate-rca"
                        onclick="generateRca()"
                        class="w-full relative overflow-hidden text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 text-sm flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-red-200 active:scale-[0.98]"
                        style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span id="btn-rca-text">{{ $report->rca_data ? 'Re-generate RCA' : 'Generate RCA' }}</span>
                    </button>
                    @if($report->rca_data)
                    <p class="text-xs text-center text-gray-400 mt-2">Klik untuk generate ulang analisis</p>
                    @endif
                </div>
            </div>

            <div class="glass-card p-5 animate-fade-in-up" style="animation-delay: 0.1s">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Update Status</h3>
                <form method="POST" action="{{ route('reports.updateStatus', $report->id) }}" class="space-y-4">
                    @csrf @method('PATCH')
                    <select name="status" class="form-input-dash w-full px-3 py-2.5 text-sm">
                        <option value="baru" {{ $report->status === 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="ditinjau" {{ $report->status === 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                        <option value="dalam_penanganan" {{ $report->status === 'dalam_penanganan' ? 'selected' : '' }}>Dalam Penanganan</option>
                        <option value="selesai" {{ $report->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $report->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <textarea name="resolution_notes" rows="3" placeholder="Catatan resolusi..." class="form-input-dash w-full px-3 py-2.5 text-sm resize-none">{{ $report->resolution_notes }}</textarea>
                    <button type="submit" class="w-full text-white font-medium py-2.5 rounded-lg transition-all duration-300 text-sm" style="background: var(--cabot-red);">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="glass-card p-5 animate-fade-in-up" style="animation-delay: 0.15s">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Tugaskan ke HSE</h3>
                <form method="POST" action="{{ route('reports.assign', $report->id) }}" class="space-y-4">
                    @csrf @method('PATCH')
                    <select name="assigned_to" class="form-input-dash w-full px-3 py-2.5 text-sm">
                        <option value="">— Pilih Tim HSE —</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $report->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->role_label }})
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-2.5 rounded-lg transition-all duration-300 text-sm">
                        Tugaskan
                    </button>
                </form>
            </div>

            <div class="glass-card p-5 animate-fade-in-up" style="animation-delay: 0.2s">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Informasi</h3>
                <div class="space-y-2 text-xs">
                    @if($report->assignedUser)
                    <div class="flex justify-between"><span class="text-gray-400">Ditangani oleh</span><span class="text-gray-700">{{ $report->assignedUser->name }}</span></div>
                    @endif
                    <div class="flex justify-between"><span class="text-gray-400">Dibuat</span><span class="text-gray-700">{{ $report->created_at->diffForHumans() }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Terakhir update</span><span class="text-gray-700">{{ $report->updated_at->diffForHumans() }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Dilihat</span><span class="text-gray-700">{{ $report->auditLogs->where('action', 'viewed')->count() }}x</span></div>
                </div>
            </div>

            <div class="pt-2">
                <form method="POST" action="{{ route('reports.destroy', $report->id) }}" id="deleteForm">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete(this)" class="w-full text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 font-medium py-2.5 rounded-lg transition-all duration-300 text-sm">
                        Hapus Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ══════════════════════════════════════════════════════════════
// RCA AI Generation
// ══════════════════════════════════════════════════════════════
const REPORT_ID = {{ $report->id }};
const CSRF_TOKEN = '{{ csrf_token() }}';
const GENERATE_URL = '{{ route("reports.generateRca", $report->id) }}';
const SAVE_URL = '{{ route("reports.saveRca", $report->id) }}';

let currentRcaData = @json($report->rca_data);

async function generateRca() {
    const btn = document.getElementById('btn-generate-rca');
    const btnText = document.getElementById('btn-rca-text');
    const loading = document.getElementById('rca-loading');
    const results = document.getElementById('rca-results');
    const errorEl = document.getElementById('rca-error');

    // Show loading, hide others
    btn.disabled = true;
    btn.classList.add('opacity-60', 'cursor-not-allowed');
    btnText.textContent = 'Menganalisis...';
    loading.classList.remove('hidden');
    results.classList.add('hidden');
    errorEl.classList.add('hidden');

    try {
        const response = await fetch(GENERATE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (data.success && data.data) {
            currentRcaData = data.data;
            renderRca(data.data);
            loading.classList.add('hidden');
            results.classList.remove('hidden');

            // Scroll to RCA section
            document.getElementById('rca-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            throw new Error(data.error || 'Gagal generate RCA');
        }
    } catch (err) {
        loading.classList.add('hidden');
        errorEl.classList.remove('hidden');
        document.getElementById('rca-error-message').textContent = err.message;
    } finally {
        btn.disabled = false;
        btn.classList.remove('opacity-60', 'cursor-not-allowed');
        btnText.textContent = 'Re-generate RCA';
    }
}

function renderRca(data) {
    // Ringkasan
    const ringkasanSection = document.getElementById('rca-ringkasan-section');
    const ringkasanEl = document.getElementById('rca-ringkasan');
    if (data.ringkasan) {
        ringkasanEl.textContent = data.ringkasan;
        ringkasanSection.classList.remove('hidden');
    } else {
        ringkasanSection.classList.add('hidden');
    }

    // Akar masalah
    const akarEl = document.getElementById('rca-akar-masalah');
    akarEl.innerHTML = '';
    if (data.akar_masalah && data.akar_masalah.length) {
        data.akar_masalah.forEach((item, idx) => {
            akarEl.innerHTML += `
                <div class="flex items-start gap-3 p-3 rounded-xl bg-red-50/50 border border-red-100/50 animate-fade-in-up" style="animation-delay: ${idx * 0.05}s">
                    <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-red-100 text-red-600 text-xs font-bold flex items-center justify-center mt-0.5">${idx + 1}</span>
                    <p class="text-sm text-gray-700">${escapeHtml(item)}</p>
                </div>`;
        });
    }

    // Kategori
    const kategoriEl = document.getElementById('rca-kategori');
    kategoriEl.innerHTML = '';
    if (data.kategori) {
        const configs = {
            manusia: { icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', bg: 'bg-blue-50/50', border: 'border-blue-100/50', iconColor: 'text-blue-500', label: 'text-blue-700' },
            proses: { icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', bg: 'bg-purple-50/50', border: 'border-purple-100/50', iconColor: 'text-purple-500', label: 'text-purple-700' },
            peralatan: { icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', bg: 'bg-orange-50/50', border: 'border-orange-100/50', iconColor: 'text-orange-500', label: 'text-orange-700' },
            lingkungan: { icon: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', bg: 'bg-emerald-50/50', border: 'border-emerald-100/50', iconColor: 'text-emerald-500', label: 'text-emerald-700' },
        };

        Object.entries(data.kategori).forEach(([kat, analisis], idx) => {
            const c = configs[kat] || configs.manusia;
            kategoriEl.innerHTML += `
                <div class="p-4 rounded-xl ${c.bg} border ${c.border} animate-fade-in-up" style="animation-delay: ${idx * 0.05}s">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 ${c.iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${c.icon}"/>
                        </svg>
                        <p class="text-xs font-bold ${c.label} uppercase">${escapeHtml(kat)}</p>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">${escapeHtml(analisis)}</p>
                </div>`;
        });
    }

    // Rekomendasi
    const rekEl = document.getElementById('rca-rekomendasi');
    rekEl.innerHTML = '';
    if (data.rekomendasi && data.rekomendasi.length) {
        data.rekomendasi.forEach((item, idx) => {
            rekEl.innerHTML += `
                <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/50 border border-emerald-100/50 animate-fade-in-up" style="animation-delay: ${idx * 0.05}s">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-gray-700">${escapeHtml(item)}</p>
                </div>`;
        });
    }

    // Update badge & timestamp
    const badge = document.getElementById('rca-status-badge');
    badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700';
    badge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft AI';

    const timestamp = document.getElementById('rca-timestamp');
    timestamp.textContent = 'Baru saja di-generate';
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ══════════════════════════════════════════════════════════════
// Delete Confirmation
// ══════════════════════════════════════════════════════════════
function confirmDelete(btn) {
    if (btn.dataset.ready === 'true') {
        btn.innerHTML = 'Menghapus...';
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        document.getElementById('deleteForm').submit();
    } else {
        btn.dataset.originalText = btn.innerHTML;
        btn.innerHTML = 'Yakin Hapus? (Klik lagi)';
        
        // Ubah warna jadi merah solid
        btn.classList.remove('text-red-500', 'hover:text-red-700', 'bg-red-50', 'hover:bg-red-100');
        btn.classList.add('text-white', 'bg-red-600', 'hover:bg-red-700');
        btn.dataset.ready = 'true';
        
        setTimeout(() => {
            if(btn.dataset.ready === 'true') {
                btn.innerHTML = btn.dataset.originalText;
                btn.classList.remove('text-white', 'bg-red-600', 'hover:bg-red-700');
                btn.classList.add('text-red-500', 'hover:text-red-700', 'bg-red-50', 'hover:bg-red-100');
                btn.dataset.ready = 'false';
            }
        }, 3000);
    }
}
</script>
@endsection

<?php

namespace App\Services;

use App\Models\IncidentReport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\ConnectionException;

class RcaService
{
    /**
     * Generate RCA analysis using Groq API.
     *
     * @param  IncidentReport  $report
     * @return array{success: bool, data?: array, error?: string}
     */
    public function generateRca(IncidentReport $report): array
    {
        $apiKey = config('services.groq.api_key');
        $model = config('services.groq.model', 'llama-3.3-70b-versatile');

        if (empty($apiKey)) {
            return [
                'success' => false,
                'error' => 'API key Groq belum dikonfigurasi. Tambahkan GROQ_API_KEY di file .env',
            ];
        }

        $prompt = $this->buildPrompt($report);

        try {
            $url = "https://api.groq.com/openai/v1/chat/completions";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($url, [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.3,
                'response_format' => ['type' => 'json_object']
            ]);

            if (!$response->successful()) {
                $errorBody = $response->json();
                $errorMsg = $errorBody['error']['message'] ?? 'Unknown API error';
                Log::error('Groq API error', [
                    'status' => $response->status(),
                    'body' => $errorBody,
                    'report_id' => $report->id,
                ]);

                return [
                    'success' => false,
                    'error' => "API Error ({$response->status()}): {$errorMsg}",
                ];
            }

            $data = $response->json();

            // Extract text from Groq response structure
            $text = $data['choices'][0]['message']['content'] ?? '';

            if (empty($text)) {
                Log::warning('Groq returned empty response', [
                    'report_id' => $report->id,
                    'response' => $data,
                ]);

                return [
                    'success' => false,
                    'error' => 'AI mengembalikan respons kosong. Coba generate ulang.',
                ];
            }

            // Parse JSON from response
            $rcaData = json_decode($text, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('RCA response parse error', [
                    'report_id' => $report->id,
                    'raw_text' => $text,
                    'json_error' => json_last_error_msg(),
                ]);

                return [
                    'success' => false,
                    'error' => 'Gagal memproses respons AI. Coba generate ulang.',
                ];
            }

            // Validate expected structure
            if (!$this->validateRcaStructure($rcaData)) {
                Log::warning('RCA response structure invalid', [
                    'report_id' => $report->id,
                    'data' => $rcaData,
                ]);

                return [
                    'success' => false,
                    'error' => 'Struktur respons AI tidak sesuai. Coba generate ulang.',
                ];
            }

            // Add metadata
            $rcaData['meta'] = [
                'generated_at' => now()->toIso8601String(),
                'model' => $model,
                'status' => 'draft',
                'catatan' => 'Draft AI-generated — perlu review HSE Officer sebelum difinalisasi.',
            ];

            return [
                'success' => true,
                'data' => $rcaData,
            ];

        } catch (ConnectionException $e) {
            Log::error('Groq API connection error', [
                'report_id' => $report->id,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Tidak dapat terhubung ke server AI. Periksa koneksi internet dan coba lagi.',
            ];
        } catch (\Exception $e) {
            Log::error('RCA generation error', [
                'report_id' => $report->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Terjadi kesalahan saat generate RCA. Silakan coba lagi.',
            ];
        }
    }

    /**
     * Build the prompt for Groq API.
     */
    private function buildPrompt(IncidentReport $report): string
    {
        $incidentTime = $report->incident_time ?? 'Tidak diketahui';

        return <<<PROMPT
Kamu adalah safety officer K3 (Keselamatan dan Kesehatan Kerja) berpengalaman di industri manufaktur/kimia. Berdasarkan data insiden berikut, lakukan analisis Root Cause Analysis (RCA) menggunakan kombinasi metode 5-Why dan diagram Fishbone (Ishikawa).

═══════════════════════════════════
DATA INSIDEN
═══════════════════════════════════
- Kode Tracking : {$report->tracking_code}
- Jenis Kejadian: {$report->incident_type_label}
- Lokasi        : {$report->location}
- Urgensi       : {$report->urgency_label}
- Tanggal       : {$report->incident_date->format('d M Y')}
- Waktu         : {$incidentTime}
- Deskripsi     : {$report->description}
═══════════════════════════════════

INSTRUKSI:
1. Lakukan penjabaran analisis 5-Why (5 pertanyaan "Mengapa" yang saling berkaitan) beserta jawabannya untuk mencari akar masalah
2. Identifikasi 3-5 kemungkinan akar masalah berdasarkan analisis tersebut
3. Analisis menggunakan 4 kategori Fishbone: Manusia, Proses, Peralatan, Lingkungan
4. Berikan 3-5 rekomendasi tindakan korektif yang spesifik dan actionable
5. Berikan ringkasan singkat analisis

Balas HANYA dengan JSON valid, format:
{
    "ringkasan": "Paragraf singkat ringkasan analisis RCA",
    "analisis_5_why": [
        {
            "pertanyaan": "Mengapa (kejadian utama)?",
            "jawaban": "Karena..."
        },
        {
            "pertanyaan": "Mengapa (jawaban sebelumnya)?",
            "jawaban": "Karena..."
        }
    ],
    "akar_masalah": [
        "Poin akar masalah 1 (dari kesimpulan 5-Why)",
        "Poin akar masalah 2",
        "Poin akar masalah 3"
    ],
    "kategori": {
        "manusia": "Analisis faktor manusia yang berkontribusi",
        "proses": "Analisis faktor proses/prosedur yang berkontribusi",
        "peralatan": "Analisis faktor peralatan/alat yang berkontribusi",
        "lingkungan": "Analisis faktor lingkungan kerja yang berkontribusi"
    },
    "rekomendasi": [
        "Tindakan korektif spesifik 1",
        "Tindakan korektif spesifik 2",
        "Tindakan korektif spesifik 3"
    ]
}
PROMPT;
    }

    /**
     * Validate the expected RCA response structure.
     */
    private function validateRcaStructure(array $data): bool
    {
        // Must have these top-level keys
        $requiredKeys = ['analisis_5_why', 'akar_masalah', 'kategori', 'rekomendasi'];
        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) {
                return false;
            }
        }

        // akar_masalah and rekomendasi must be arrays with at least 1 item
        if (!is_array($data['akar_masalah']) || count($data['akar_masalah']) < 1) {
            return false;
        }
        if (!is_array($data['rekomendasi']) || count($data['rekomendasi']) < 1) {
            return false;
        }

        // kategori must have the 4 expected keys
        $expectedKategori = ['manusia', 'proses', 'peralatan', 'lingkungan'];
        foreach ($expectedKategori as $kat) {
            if (!isset($data['kategori'][$kat])) {
                return false;
            }
        }

        return true;
    }
}

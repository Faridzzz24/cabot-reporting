# Alur Kerja (Workflow) Sistem Pelaporan Insiden K3 PT Cabot

Dokumen ini menjelaskan alur kerja dari aplikasi pelaporan insiden K3 (Kesehatan dan Keselamatan Kerja) secara keseluruhan, mulai dari proses pelaporan oleh publik (karyawan/kontraktor) hingga proses penanganan oleh pihak internal perusahaan (SHE Officer, Supervisor, dan Admin).

---

## 1. Alur Pelapor (Publik / Tanpa Login)
Halaman utama sistem ini didesain agar sangat mudah diakses tanpa harus membuat akun atau *login*. Hal ini bertujuan agar pelaporan dapat dilakukan dengan cepat saat keadaan darurat.

1. **Akses Halaman Utama (Landing Page)**: Pelapor mengakses URL website dan akan disambut dengan informasi terkait pentingnya K3.
2. **Proses LMRA (Last Minute Risk Assessment)**:
   - Sebelum mengisi formulir, pelapor akan melihat kartu interaktif panduan **STOP, THINK, ACT**.
   - Panduan ini memastikan pelapor atau pekerja melakukan penilaian risiko cepat sebelum melanjutkan aktivitas.
3. **Pengisian Formulir Insiden**:
   - Pelapor memilih **Jenis Insiden** (Near Miss, Kecelakaan Kerja, Tumpahan Bahan Kimia, dll).
   - Menentukan **Tingkat Urgensi** (Rendah, Sedang, Tinggi, Kritis).
   - Mengisi waktu, lokasi kejadian, dan deskripsi detail.
   - Melampirkan foto kejadian (opsional).
4. **Mendapatkan Kode Pelacakan (Tracking Code)**:
   - Setelah laporan dikirim, sistem akan menghasilkan kode unik (misal: `REP-XYZ123`).
   - Pelapor dapat menggunakan kode ini di menu "Lacak Laporan" untuk memantau status laporannya tanpa perlu *login*.

---

## 2. Alur Pengelolaan & Penanganan (Dashboard Internal)
Setelah laporan masuk, sistem backend akan memproses laporan tersebut. Pihak internal yang memiliki akun dapat *login* untuk mengelola laporan sesuai dengan hak akses (Role) masing-masing.

### A. Peran: SHE Officer (Petugas K3)
SHE Officer adalah gerbang utama yang meninjau semua laporan baru yang masuk.
- **Tinjauan Awal**: Melihat laporan berstatus **"Baru"**.
- **Update Status**: Mengubah status laporan menjadi **"Ditinjau"**.
- **Penugasan (Assignment)**: Jika laporan membutuhkan tindakan fisik/perbaikan di lapangan, SHE Officer dapat menugaskan laporan tersebut kepada **Supervisor** terkait.
- **Eskalasi/Penyelesaian**: Mengubah status ke **"Dalam Penanganan"** hingga **"Selesai"**.
- **Export Data**: Mengunduh rekapitulasi data laporan untuk kebutuhan audit K3 bulanan (PDF/Excel).

### B. Peran: Supervisor (Pengawas Lapangan)
Supervisor bertugas menindaklanjuti laporan yang telah ditugaskan kepadanya oleh SHE Officer.
- **Menerima Tugas**: Melihat daftar laporan yang di-*assign* ke dirinya.
- **Tindakan Perbaikan**: Melakukan inspeksi atau perbaikan di lokasi kejadian.
- **Update Progress**: Mengubah status laporan (misalnya dari "Ditinjau" menjadi "Dalam Penanganan" lalu "Selesai").

### C. Peran: Administrator
Admin adalah pemegang kendali penuh atas sistem aplikasi.
- **Manajemen Pengguna**: Bisa membuat akun baru untuk SHE Officer atau Supervisor, mengubah *password*, dan menghapus akun.
- **Kendali Penuh Laporan**: Memiliki semua akses yang dimiliki oleh SHE Officer dan Supervisor.
- **Manajemen Data**: Berhak menghapus laporan yang dianggap *spam* atau tidak valid.

---

## 3. Siklus Hidup Laporan (Status Flow)
Setiap laporan yang masuk akan melewati beberapa tahap status (State):

1. 🔴 **Baru (New)**: Laporan baru saja dikirim oleh pelapor.
2. 🟡 **Ditinjau (Reviewed)**: Laporan sedang dibaca dan diverifikasi oleh SHE Officer.
3. 🔵 **Dalam Penanganan (Handling)**: Laporan sedang ditindaklanjuti atau diperbaiki di lapangan oleh Supervisor/Tim Teknis.
4. 🟢 **Selesai (Completed)**: Tindakan perbaikan telah selesai dan area kembali aman.
5. ⚫ **Ditolak (Rejected)**: Laporan ditolak (misal: laporan palsu, *spam*, atau duplikat).

---

## Ringkasan Eksekutif
Sistem ini memastikan bahwa **setiap insiden K3 yang terjadi di lingkungan PT Cabot tidak akan terlewatkan**. Pelapor diberikan kemudahan pelaporan secepat mungkin (tanpa hambatan login), sementara pihak manajemen (SHE & Supervisor) memiliki dasbor terstruktur untuk memantau, menangani, dan mengarsipkan laporan secara profesional dan akuntabel.

# Panduan Deploy: Vercel + Aiven MySQL

Panduan ini menjelaskan cara men-deploy website Pelaporan K3 PT Cabot ke **Vercel** (hosting) dengan database **Aiven MySQL** (gratis).

---

## Langkah 1: Buat Database MySQL di Aiven

1. Kunjungi [Aiven.io](https://aiven.io/) dan buat akun gratis.
2. Klik **Create Service** → pilih **MySQL**.
3. Pilih **Free Plan** (Hobbyist) dan region terdekat (contoh: Singapore).
4. Tunggu hingga status database menjadi **Running**.
5. Klik service MySQL yang baru dibuat, lalu catat informasi koneksi berikut:
   - **Host** (contoh: `mysql-xxxxx-xxxxx.aiven.io`)
   - **Port** (biasanya `25060`)
   - **User** (biasanya `avnadmin`)
   - **Password** (klik tombol mata untuk melihat)
   - **Database Name** (biasanya `defaultdb`)

---

## Langkah 2: Upload Kode ke GitHub

1. Buat repository baru di [GitHub](https://github.com/) (Private atau Public).
2. Push kode dari komputer Anda ke GitHub:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/USERNAME/REPO-NAME.git
   git push -u origin main
   ```

> **Penting:** Pastikan file `.env` sudah masuk di `.gitignore` (sudah ada secara default).

---

## Langkah 3: Deploy ke Vercel

1. Kunjungi [Vercel](https://vercel.com/) dan login dengan akun GitHub.
2. Klik **Add New Project** → pilih repository Anda.
3. Di bagian **Environment Variables**, tambahkan variabel berikut:

| Nama Variabel | Nilai | Keterangan |
|---|---|---|
| `APP_NAME` | `PT Cabot Safety Report` | Nama aplikasi |
| `APP_ENV` | `production` | Mode production |
| `APP_DEBUG` | `false` | Matikan debug di production |
| `APP_KEY` | `base64:CYyVf2RfIYtdDB+cv9llBTcrnGOa5IwOdvUhV3rWnUA=` | Encryption key (gunakan yang sama dari `.env` lokal) |
| `APP_URL` | `https://nama-project.vercel.app` | URL Vercel Anda |
| `DB_CONNECTION` | `mysql` | Tipe database |
| `DB_HOST` | *(dari Aiven)* | Host database Aiven |
| `DB_PORT` | `25060` | Port database Aiven |
| `DB_DATABASE` | `defaultdb` | Nama database Aiven |
| `DB_USERNAME` | `avnadmin` | Username database Aiven |
| `DB_PASSWORD` | *(dari Aiven)* | Password database Aiven |
| `MYSQL_ATTR_SSL_CA` | *(kosongkan atau path CA cert)* | SSL certificate Aiven |

4. Klik **Deploy** dan tunggu proses build selesai (~2-3 menit).

---

## Langkah 4: Jalankan Migration (Pertama Kali Saja)

Setelah database Aiven aktif, Anda perlu menjalankan migration **sekali saja** dari komputer lokal:

1. Pastikan file `.env` lokal sudah diisi credential Aiven yang benar.
2. Jalankan perintah:
   ```bash
   php artisan migrate --force
   ```
3. Jalankan seeder untuk membuat akun default:
   ```bash
   php artisan db:seed --force
   ```
4. Selesai! Database sudah siap digunakan. Data akan tetap tersimpan secara permanen.

---

## Troubleshooting

### Website error 500 setelah deploy
- Cek **Vercel Function Logs** (di dashboard Vercel → tab Functions → Logs).
- Pastikan semua Environment Variables sudah diisi dengan benar.
- Pastikan `APP_KEY` sudah di-set.

### "Access denied" atau "Connection refused"
- Pastikan `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` sudah benar.
- Pastikan database Aiven statusnya **Running** (bukan *Rebuilding*).
- Aiven MySQL membutuhkan SSL — pastikan koneksi menggunakan SSL.

### Asset CSS/JS tidak muncul (tampilan rusak)
- Pastikan di `vercel.json` sudah ada `buildCommand: "npm install && npm run build"`.
- Pastikan folder `public/build/` berisi file hasil compile Vite.

### Data hilang setelah deploy ulang
- Data di database Aiven bersifat **persisten** — data tidak akan hilang.
- Yang hilang hanya file yang di-upload ke `/tmp` (foto insiden). Untuk solusi permanen, gunakan cloud storage (S3/Cloudinary).

---

## Catatan Penting

> **Upload Foto:** Foto yang di-upload melalui form laporan disimpan di filesystem lokal (`storage/app/public`). Di Vercel (serverless), file ini bersifat **sementara** dan akan hilang setelah cold start. Untuk produksi jangka panjang, pertimbangkan menggunakan layanan cloud storage seperti Cloudinary atau AWS S3.

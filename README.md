# Project Laravel - Kelola Produk & Kategori

Aplikasi sederhana untuk mengelola data produk menggunakan Laravel (CRUD - Create, Read, Update, Delete). Dokumen ini menjelaskan alur kerja dari fitur kelola produk dari awal pembentukan proyek.

## 1. Konsep Dasar Laravel (MVC) & Persiapan Awal Proyek

Bagi pemula, bayangkan Laravel dan konsep MVC (*Model-View-Controller*) itu seperti sebuah restoran:
- **Router (Pelayan)**: Menerima pesanan pengunjung (contoh: user mengetikkan URL web) dan mencatat apa yang sedang diminta.
- **Controller (Manajer Dapur)**: Router menyerahkan pesanan tadi ke Controller. Controller akan berpikir logika apa yang harus dijalankan, data apa yang harus disiapkan, dan ke mana harus dikirim. Dia yang mengontrol semuanya.
- **Model & Database (Prosedur & Gudang Bahan Baku)**: Tempat penyimpanan semua data. Jika Controller butuh daftar produk, dia tidak langsung ke gudang, tapi menggunakan Model sebagai "prosedur resmi" untuk berkomunikasi dengan Database.
- **View (Piring Sajian / Tampilan)**: Setelah data siap, data tersebut dirias dan ditata di dalam View (berupa file HTML/Blade) agar cantik saat dilihat oleh user.

Sebelum masuk ke alur fitur Add atau Update, tahapan fundamental yang dilakukan saat awal proyek terbentuk adalah:

1. **Konfigurasi Database (`.env`)**
   - Menghubungkan aplikasi Laravel dengan database MySQL lokal Anda. Sederhananya, ini adalah memberi "kunci gudang" agar aplikasi bisa membaca dan menyimpan data.
2. **Migration (Pembuatan Struktur Tabel)**
   - Membuat "kerangka penyimpanan" (struktur fisik tabel `tb_produk` di database) melalui kode bawaan Laravel, sehingga kita tidak membuat tabel manual satu-persatu lewat PHPMyAdmin.
   - Tabel ini berisi "laci-laci" (kolom) utama seperti: `id_produk` (*Primary Key* atau nomor unik identitas data), `nama_produk`, `harga`, `deskripsi_produk`, dan `kategori_id`.
3. **Model (`app/Models/produk.php`)**
   - Membuat jembatan atau perwakilan dari tabel `tb_produk` tadi.
   - Kita wajib mentraining Model ini agar dia kenal dengan tabel aslinya, yaitu dengan cara:
     - Memberi tahu nama tabel aslinya: `protected $table = "tb_produk"`
     - Memberi tahu mana identitas utamanya: `protected $primaryKey = "id_produk"`
     - Mengatur izin data apa saja yang boleh diisi langsung oleh user dari form (disebut *Mass Assignment*): `protected $fillable = ['nama_produk', 'harga', 'deskripsi_produk', 'kategori_id']`. Tanpa ini, form isian akan ditolak untuk alasan keamanan.

---

## 2. Alur Proses Tambah Produk (Add / Create)

Alur penambahan data terdiri dari dua siklus / *request* oleh user:

### Tahap A: Menampilkan Halaman Form
1. **User Request**: User menekan tombol "Tambah Data" di halaman utama. Browser akan melakukan request `GET` ke URL `/produk/create`.
2. **Router (`routes/web.php`)**: Sistem Laravel menangkap request URL tersebut dan mengarahkannya ke `productController` pada method `create`.
3. **Controller (`create()`)**: Controller memproses intruksi. Disini fungsinya hanya mengembalikan (me-return) file tampilan.
4. **View (`add.blade.php`)**: User melihat halaman berupa Form HTML. Form ini di-set dengan aturan:
   - `action="/produk"` (Tujuan data dikirim)
   - `method="POST"` (Metode pengiriman agar data tidak terlihat di URL)
   - Menyisipkan `@csrf` token untuk keamanan dari serangan *Cross-Site Request Forgery*.

### Tahap B: Proses Penyimpanan Data (Submit)
1. **User Submit**: User mengisi form dan menekan "Submit". Data Inputan dilempar.
2. **Router**: Router menangkap request method `POST` dari `/produk`, lalu diarahkan ke method `store` di controller.
3. **Controller (`store(Request $request)`)**:
   - **Validasi Data**: Baris kode `$request->validate([...])` mengecek apakah `$request` memenuhi syarat (misal: harus diisi, harga harus berupa angka).
   - *Jika gagal*: Laravel secara **otomatis mundur** (redirect) ke form sebelumnya dengan membawa pesan error.
   - *Jika sukses*: Eksekusi berlanjut menyimpan data ke database memanggil `produk::create([...])`.
   - **Merespon (Redirect)**: Sistem mengarahkan user kembali ke halaman daftar produk (`/produk`) dengan status berhasil ditambah.

---

## 3. Alur Proses Mengubah Produk (Edit & Update)

Sama seperti proses Create, proses Update juga terdiri dari dua langkah utama. Letak perbedaannya ada pada pengambilan *ID* produk yang spesifik.

### Tahap A: Menampilkan Form Berisi Data Lama
1. **User Request**: User menekan tombol "Edit" pada salah satu baris produk. Mengarah ke URL `/produk/{id_produk}/edit` (contoh: `/produk/5/edit`).
2. **Router**: Menangkap request method `GET` dan URL beserta ID, lalu disalurkan ke method `edit`.
3. **Controller (`edit($id_produk)`)**:
   - Mengambil data eksisting ke model: `produk::findOrFail($id_produk)`. Database akan di-query `SELECT * WHERE id_produk=5`.
   - Mengirimkan variabel kumpulan data tersebut ke file view untuk di-render.
4. **View (`edit.blade.php`)**: Form HTML muncul dengan keadaan kotak isian **sudah terisi** nilai bawaan (dari `$data->nama_produk` dsb). Form di-set dengan `action="/produk/5"` dan direktif tambahan `@method('PUT')` (karena standar formulir HTML belum mendukung PUT secara 100%).

### Tahap B: Menyimpan Perubahan (Submit Edit)
1. **User Submit**: User mengubah beberapa isian dan men-submit. Request mengarah ke URL spesifik (`/produk/5`) dengan metode pengamanan bawaan `PUT`.
2. **Router**: Router menangkap kombinasi URL dan method `PUT` lalu mengeksekusi controller method `update`.
3. **Controller (`update(Request $request, $id_produk)`)**:
   - **Validasi Data**: Mengecek validitas field baru (sama seperti tahapan simpan biasa).
   - **Proses Update Database**: Memanggil fungsi dari Eloquent `produk::where('id_produk', $id_produk)->update([...])`. Sistem melakukan perintah query `UPDATE`.
   - **Merespon (Redirect)**: Kembalikan user ke `/produk` dengan pop-up notifikasi update sukses.

---

## 4. Alur Proses Menghapus Produk (Delete)

Proses penghapusan data berdasarkan ID produk yang dipilih.

### Alur Hapus dengan Konfirmasi
1. **User Request (Klik Tombol)**: User menekan tombol "Hapus" di halaman daftar produk. Pada file `show.blade.php`, tombol ini dilengkapi dengan JavaScript: `onclick="return confirm('...') "`.
2. **Pop-up Konfirmasi**: Browser akan menampilkan kotak dialog konfirmasi.
   - *Jika Batal (Cancel)*: Proses berhenti, tidak ada data yang dikirim ke server.
   - *Jika Yakin (OK)*: Browser melanjutkan request `GET` ke URL `/produk/{id_produk}/delete`.
3. **Router (`routes/web.php`)**: Menangkap request tersebut dan meneruskannya ke method `destroy` pada controller.
4. **Controller (`destroy($id_produk)`)**:
   - **Mencari Data**: Sistem memastikan data ada di database menggunakan `produk::findOrFail($id_produk)`.
   - **Proses Hapus**: Mengeksekusi perintah `$data->delete()`. Laravel akan mengirim perintah `DELETE` ke database.
5. **Merespon (Redirect)**: Controller mengarahkan user kembali ke halaman utama `/produk` dengan pesan notifikasi "Data berhasil dihapus".

---

## 5. Alur Proses Pencarian Produk (Search)

Fitur pencarian memungkinkan user untuk mencari produk berdasarkan kata kunci yang dimasukkan.

### Alur Kerja Pencarian
1. **User Input & Request**: User memasukkan kata kunci di *search bar* dan menekan tombol "Cari Produk". Browser melakukan request `GET` ke URL `/produk/search?keyword=nama_barang`.
2. **Router (`routes/web.php`)**: Router menangkap request tersebut dan mengarahkannya ke `productController` pada method `search`.
3. **Controller (`search(Request $request)`)**:
   - **Mencapai Keyword**: Mengambil kata kunci dari `$request->keyword`.
   - **Query Database**: Melakukan pencarian menggunakan SQL `LIKE` pada kolom `nama_produk` atau `deskripsi_produk`.
   - **Mengirim Data**: Mengembalikan view `show.blade.php` dengan data hasil pencarian.
4. **View (`show.blade.php`)**: 
   - Jika data ditemukan, daftar produk akan diperbarui sesuai hasil pencarian.
   - Jika data kosong, muncul pesan "Data tidak tersedia" (menggunakan direktif `@forelse`).
   - Muncul tombol **"Kembali"** untuk mereset pencarian dan kembali ke daftar lengkap semua produk.

---

## 6. Kelola Kategori (Resource Controller)

Berbeda dengan produk, fitur **Kategori** diimplementasikan menggunakan **Resource Controller** untuk efisiensi kode.

### Perbedaan Utama:
- **Route Resource**: Menggunakan `Route::resource('kategori', kategoriController::class)`. Satu baris ini otomatis menyediakan 7 route standar (index, create, store, show, edit, update, destroy).
- **Custom Search**: Fitur pencarian ditambahkan secara manual di luar resource. Route search diletakkan **di atas** route resource agar tidak bentrok dengan pencarian ID.

### Alur Pencarian Kategori:
1. **Request**: User mengirim keyword melalui form dengan method `GET`.
2. **Controller (`search`)**: 
   - Mengambil keyword.
   - Menggunakan operator `LIKE` dengan *wildcard* (`%`) pada kolom `nama_kategori` dan `deskripsi`.
   - Mengembalikan data ke view list kategori.
3. **View**: Data ditampilkan menggunakan template yang sama dengan halaman utama kategori, memberikan pengalaman user yang konsisten.

---

## 7. Fitur Upload Gambar Produk

Fitur ini memungkinkan user menambahkan gambar pada produk. Gambar disimpan secara fisik ke folder `public/gambar_produk/`, sementara nama file-nya dicatat di database pada kolom `gambar` di tabel `tb_produk`. Untuk menghindari kesamaan nama file, setiap gambar yang di-upload akan diberi nama acak menggunakan `Str::random()` dengan ekstensi asli file dipertahankan.

### 7.1 Persiapan Awal (Fondasi)

Sebelum fitur ini bisa berjalan, ada beberapa hal yang perlu disiapkan terlebih dahulu:

1. **Migration (Kolom `gambar` di tabel `tb_produk`)**
   - Di dalam file migration `create_produks_table.php`, kolom `gambar` sudah ditambahkan sebagai `string` dan bersifat `nullable` (boleh kosong). Artinya, produk tetap bisa dibuat tanpa harus menyertakan gambar.
   - Kode migration-nya:
     ```php
     $table->string('gambar')->nullable();
     ```

2. **Model (`app/Models/produk.php`)**
   - Kolom `gambar` harus didaftarkan di dalam property `$fillable` agar Laravel mengizinkan data gambar diisi melalui *Mass Assignment* (metode `create()` dan `update()`).
   - Kode model:
     ```php
     protected $fillable = ['nama_produk','harga','deskripsi_produk','stok','kode_barang','kategori_id','gambar'];
     ```

3. **Folder Penyimpanan (`public/gambar_produk/`)**
   - Folder ini dibuat secara manual di dalam direktori `public/`. Semua file gambar yang di-upload akan disimpan di sini. Folder ini bisa diakses langsung oleh browser melalui URL karena berada di dalam `public/`.

4. **Import Tambahan di Controller**
   - `Illuminate\Support\Str` — untuk menghasilkan string acak sebagai nama file.
   - `Illuminate\Support\Facades\File` — untuk operasi file seperti mengecek keberadaan dan menghapus file lama.

---

### 7.2 Alur Upload Gambar Saat Tambah Produk (Store)

Alur ini terjadi ketika user menambahkan produk baru beserta gambarnya.

#### Tahap A: Menampilkan Form Tambah Produk
1. **View (`add.blade.php`)**: Form sudah dilengkapi dengan:
   - Atribut `enctype="multipart/form-data"` pada tag `<form>`. **Ini wajib** agar form bisa mengirim data file (bukan hanya teks biasa).
   - Input file bertipe `<input type="file" name="gambar">` dengan atribut `accept="image/*"` agar dialog pilih file hanya menampilkan gambar.
   - Pesan bantuan di bawah input: *"Format: jpeg, png, jpg, gif, webp. Maksimal 2MB."*

#### Tahap B: Proses Penyimpanan (Submit Form)
1. **User Submit**: User mengisi semua field termasuk memilih file gambar, lalu menekan tombol "Submit".
2. **Router**: Request `POST` ke `/produk` ditangkap dan diarahkan ke method `store`.
3. **Controller (`store(Request $request)`)** — proses berjalan secara berurutan:

   **Langkah 1 — Validasi:**
   ```php
   'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
   ```
   - `nullable`: Gambar boleh tidak diisi (opsional).
   - `image`: File harus berupa gambar.
   - `mimes:jpeg,png,jpg,gif,webp`: Hanya format ini yang diterima.
   - `max:2048`: Ukuran maksimal 2MB (2048 KB).
   - Jika validasi gagal, Laravel otomatis kembali ke form dengan pesan error.

   **Langkah 2 — Pengecekan File:**
   ```php
   $namaGambar = null;
   if ($request->hasFile('gambar')) {
   ```
   - Variabel `$namaGambar` diinisialisasi `null` (artinya tanpa gambar).
   - `$request->hasFile('gambar')` mengecek apakah user benar-benar mengunggah file.

   **Langkah 3 — Generate Nama Acak:**
   ```php
   $ekstensi = $request->file('gambar')->getClientOriginalExtension();
   $namaGambar = Str::random(30) . '.' . $ekstensi;
   ```
   - `getClientOriginalExtension()` mengambil ekstensi asli file yang di-upload (misal: `jpg`, `png`).
   - `Str::random(30)` menghasilkan 30 karakter acak (huruf dan angka) sebagai nama file baru.
   - Hasil akhir contoh: `aB3xK9mNpQ2rS5tU8vW0yZ1cE4fG7.jpg`.
   - Tujuannya: **mencegah konflik nama file** jika dua user meng-upload gambar dengan nama yang sama.

   **Langkah 4 — Simpan File ke Folder:**
   ```php
   $request->file('gambar')->move(public_path('gambar_produk'), $namaGambar);
   ```
   - `public_path('gambar_produk')` menghasilkan path absolut ke folder `public/gambar_produk/`.
   - Method `move()` memindahkan file dari lokasi sementara (temporary) ke folder tujuan dengan nama baru.

   **Langkah 5 — Simpan ke Database:**
   ```php
   produk::create([
       ...
       'gambar' => $namaGambar,
   ]);
   ```
   - Nama file gambar (bukan file-nya sendiri) disimpan ke kolom `gambar` di database.
   - Jika user tidak upload gambar, kolom ini berisi `null`.

4. **Redirect**: User diarahkan kembali ke halaman daftar produk dengan pesan sukses.

---

### 7.3 Alur Menampilkan Gambar di Detail Produk

Gambar produk hanya ditampilkan di halaman **detail produk**, bukan di halaman daftar.

1. **User Request**: User menekan tombol "Detail" pada salah satu produk. Browser mengirim request `GET` ke `/produk/{id_produk}`.
2. **Controller (`detail($id_produk)`)**: Mengambil data produk beserta kategorinya menggunakan `join` tabel:
   ```php
   $data_produk = produk::join('tb_kategori', 'tb_produk.kategori_id', '=', 'tb_kategori.id_kategori')
       ->where('id_produk', $id_produk)
       ->firstOrFail();
   ```
3. **View (`detail.blade.php`)**: Tampilan mengecek apakah kolom `gambar` berisi data atau `null`:

   **Jika ada gambar:**
   ```blade
   @if($data_produk->gambar)
       <img src="{{ asset('gambar_produk/' . $data_produk->gambar) }}" ...>
   ```
   - `asset('gambar_produk/namafile.jpg')` menghasilkan URL lengkap yang bisa diakses browser, contoh: `http://localhost:8000/gambar_produk/aB3xK9mNpQ2rS5tU8vW0yZ1cE4fG7.jpg`.

   **Jika belum ada gambar:**
   ```blade
   @else
       <p>Belum ada gambar</p>
       <a href="/produk/{{ $data_produk->id_produk }}/edit">Tambahkan Gambar Sekarang</a>
   @endif
   ```
   - Menampilkan ikon placeholder, pesan *"Belum ada gambar"*, dan tombol yang langsung mengarahkan user ke halaman edit untuk menambahkan gambar.

---

### 7.4 Alur Ganti Gambar Saat Edit Produk (Update)

Saat mengedit produk, user memiliki opsi untuk mengganti gambar yang sudah ada dengan gambar baru.

#### Tahap A: Menampilkan Form Edit dengan Preview Gambar
1. **View (`edit.blade.php`)**: Form edit sudah dilengkapi:
   - Atribut `enctype="multipart/form-data"` pada `<form>`.
   - **Preview gambar saat ini**: Jika produk sudah memiliki gambar, gambar tersebut ditampilkan di atas input file sebagai referensi visual bagi user.
     ```blade
     @if($data->gambar)
         <img src="{{ asset('gambar_produk/' . $data->gambar) }}" alt="Gambar saat ini">
         <p>Gambar saat ini. Pilih file baru di bawah untuk mengganti.</p>
     @endif
     ```
   - Input file untuk memilih gambar baru (opsional — jika tidak memilih file baru, gambar lama tetap dipertahankan).

#### Tahap B: Proses Update (Submit Edit)
1. **User Submit**: User mengubah data dan/atau memilih gambar baru, lalu menekan "Submit".
2. **Router**: Request `PUT` ke `/produk/{id_produk}` ditangkap dan diarahkan ke method `update`.
3. **Controller (`update(Request $request, $id_produk)`)** — proses berjalan berurutan:

   **Langkah 1 — Validasi:** Sama seperti saat store, validasi `gambar` bersifat `nullable`.

   **Langkah 2 — Siapkan Data Update (Tanpa Gambar Dulu):**
   ```php
   $dataUpdate = [
       'nama_produk' => $request->nama_produk_,
       'harga' => $request->harga_produk,
       ...
   ];
   ```
   - Data update disiapkan dalam array terlebih dahulu **tanpa** kolom `gambar`. Ini agar jika user tidak mengganti gambar, kolom gambar di database tidak ikut berubah (tetap mempertahankan gambar lama).

   **Langkah 3 — Cek Apakah Ada Gambar Baru:**
   ```php
   if ($request->hasFile('gambar')) {
   ```
   - Jika user **tidak** memilih file baru, blok ini dilewati dan gambar lama tetap utuh.
   - Jika user **memilih** file baru, proses berlanjut ke langkah berikutnya.

   **Langkah 4 — Hapus Gambar Lama dari Folder:**
   ```php
   $produkLama = produk::findOrFail($id_produk);
   if ($produkLama->gambar && File::exists(public_path('gambar_produk/' . $produkLama->gambar))) {
       File::delete(public_path('gambar_produk/' . $produkLama->gambar));
   }
   ```
   - Mengambil data produk lama dari database untuk mendapatkan nama file gambar lama.
   - `File::exists(...)` mengecek apakah file tersebut benar-benar ada di folder (menghindari error jika file sudah terhapus manual).
   - `File::delete(...)` menghapus file gambar lama dari folder `public/gambar_produk/`. **Tujuannya agar folder tidak menumpuk file-file lama yang sudah tidak terpakai.**

   **Langkah 5 — Simpan Gambar Baru:**
   ```php
   $ekstensi = $request->file('gambar')->getClientOriginalExtension();
   $namaGambar = Str::random(30) . '.' . $ekstensi;
   $request->file('gambar')->move(public_path('gambar_produk'), $namaGambar);
   $dataUpdate['gambar'] = $namaGambar;
   ```
   - Proses sama seperti saat store: generate nama acak, simpan file ke folder.
   - Nama file baru ditambahkan ke array `$dataUpdate` agar ikut di-update ke database.

   **Langkah 6 — Update Database:**
   ```php
   produk::where('id_produk', $id_produk)->update($dataUpdate);
   ```
   - Jika ada gambar baru, `$dataUpdate` berisi kolom `gambar` → database di-update.
   - Jika tidak ada gambar baru, `$dataUpdate` **tidak** berisi kolom `gambar` → nilai lama di database tetap utuh.

4. **Redirect**: User diarahkan kembali ke halaman daftar produk dengan pesan sukses.

---

### 7.5 Ringkasan File yang Terlibat

| File | Peran |
|------|-------|
| `database/migrations/create_produks_table.php` | Mendefinisikan kolom `gambar` (nullable) di tabel `tb_produk` |
| `app/Models/produk.php` | Mendaftarkan `gambar` di `$fillable` agar bisa diisi via Mass Assignment |
| `app/Http/Controllers/productController.php` | Logika upload, validasi, rename acak, simpan file, dan hapus file lama |
| `resources/views/pages/produk/add.blade.php` | Form tambah produk + input file gambar |
| `resources/views/pages/produk/edit.blade.php` | Form edit produk + preview gambar lama + input file pengganti |
| `resources/views/pages/produk/detail.blade.php` | Menampilkan gambar atau pesan "belum ada gambar" |
| `public/gambar_produk/` | Folder penyimpanan fisik file gambar yang di-upload |

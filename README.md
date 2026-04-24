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

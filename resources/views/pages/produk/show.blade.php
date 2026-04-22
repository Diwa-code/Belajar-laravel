@extends('layouts.master')

@section('content')
    <h1>Daftar Produk Kami</h1>
    <hr>
    @if (session('pesan'))
    <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif
    {{-- Form Pencarian Produk --}}
    <form action="/produk/search" method="GET">
        <div class="input-group mb-3">
            {{-- Input keyword pencarian, tetap menampilkan keyword yang dicari (persistence) --}}
            <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="Cari Produk" aria-label="Masukkan Nama Produk" aria-describedby="button-addon2">
            
            {{-- Tombol submit pencarian --}}
            <button class="btn btn-outline-secondary btn-primary text-white" type="submit" id="button-addon2">Cari Produk</button>
            
            {{-- Tombol Kembali yang hanya muncul jika user sedang dalam mode pencarian --}}
            @if (request('keyword'))
                <a href="/produk" class="btn btn-secondary ms-2">Kembali</a>
            @endif
        </div>
    </form>
    <a href="/produk/create" class="btn btn-success mb-3">Tambah Produk</a>
    <div class="card">
  <div class="card-body">
    <table class="table">
    <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Nama Barang</th>
      <th scope="col">Harga</th>
      <th scope="col">Deskripsi Barang</th>
      <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>
      {{-- Menampilkan data produk menggunakan @forelse untuk handle data kosong --}}
      @forelse ($data_produk as $item)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $item -> nama_produk }}</td>
      <td>{{ $item -> harga }}</td>
      <td>{{ $item -> deskripsi_produk }}</td>
      <td>
        <a href="/produk/{{ $item->id_produk }}/delete" class="btn btn-danger mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')">Hapus</a>
        <a href="/produk/{{ $item->id_produk }}/edit" class="btn btn-warning ms-4 mt-2">Edit</a>
        <a href="/produk/{{ $item->id_produk }}" class="btn btn-info mb-2 mt-4">Detail</a>
      </td>
    </tr>
      {{-- Pesan yang muncul jika hasil pencarian atau data produk kosong --}}
      @empty
    <tr>
        <td colspan="5" class="text-center">Data tidak tersedia</td>
    </tr>
      @endforelse
    </tbody>
    </table>
  </div>
</div>
    
@endsection
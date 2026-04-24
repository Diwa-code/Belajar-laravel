@extends('layouts.master')

@section('content')
    <h1>Daftar Kategori Produk</h1>
    <hr>
    @if (session('pesan'))
        <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif
    {{-- Form Pencarian Produk --}}
    <form action="/kategori/search" method="GET">
        <div class="input-group mb-3">
            {{-- Input keyword pencarian, tetap menampilkan keyword yang dicari (persistence) --}}
            <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}"
                placeholder="Cari Kategori" aria-label="Masukkan Nama Kategori" aria-describedby="button-addon2">

            {{-- Tombol submit pencarian --}}
            <button class="btn btn-outline-secondary btn-primary text-white" type="submit" id="button-addon2">Cari
                Kategori</button>

            {{-- Tombol Kembali yang hanya muncul jika user sedang dalam mode pencarian --}}
            @if (request('keyword'))
                <a href="/kategori" class="btn btn-secondary ms-2">Kembali</a>
            @endif
        </div>
    </form>
    <a href="/kategori/create" class="btn btn-success mb-3">Tambah Kategori</a>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Menampilkan data produk menggunakan @forelse untuk handle data kosong --}}
                    @forelse ($data_kategori as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>
                                <form action="/kategori/{{ $item->id_kategori }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')">Hapus</button>
                                </form>
                                <a href="/kategori/{{ $item->id_kategori }}/edit" class="btn btn-warning mt-2 ms-2">Edit</a>
                                <a href="/kategori/{{ $item->id_kategori }}" class="btn btn-info mt-2 ms-2">Detail</a>
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
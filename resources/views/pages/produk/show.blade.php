@extends('layouts.master')

@section('content')
    <h1>Daftar Produk Kami</h1>
    <hr>
    @if (session('pesan'))
    <div class="alert alert-success">{{ session('pesan') }}</div>
    @endif
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
      @foreach ($data_produk as $item)
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
      @endforeach
    </tbody>
    </table>
  </div>
</div>
    
@endsection
@extends('layouts.master')

@section('content')
    <h1>Detail Produk</h1>
    <hr>
    <div class="card">
  <div class="card-body">
    <img src="..." class="img-fluid" alt="...">
    <ul class="list-group list-group-flush">
  <li class="list-group-item">{{ "id produk = " . $data_produk->id_produk }}</li>
  <li class="list-group-item">{{ "nama produk = " . $data_produk->nama_produk }}</li>
  <li class="list-group-item">{{ "harga = Rp. ". number_format($data_produk->harga, 0, ',', '.') }}</li> <!-- cara memformat uang -->
  <li class="list-group-item">{{ "deskripsi = " . $data_produk->deskripsi_produk }}</li>
</ul>
<a href="/produk" class="btn btn-primary">Kembali</a>
  </div>
</div>
    
@endsection
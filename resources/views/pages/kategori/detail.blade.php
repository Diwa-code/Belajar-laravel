@extends('layouts.master')

@section('content')
    <h1>Detail Kategori</h1>
    <hr>
    <div class="card">
  <div class="card-body">
    <img src="..." class="img-fluid" alt="...">
    <ul class="list-group list-group-flush">
  <li class="list-group-item">{{ "id kategori = " . $data_kategori->id_kategori }}</li>
  <li class="list-group-item">{{ "nama kategori = " . $data_kategori->nama_kategori }}</li>
  <li class="list-group-item">{{ "deskripsi = " . $data_kategori->deskripsi }}</li>
</ul>
<a href="/kategori" class="btn btn-primary">Kembali</a>
  </div>
</div>
    
@endsection
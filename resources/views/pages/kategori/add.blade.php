@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Data Produk</div>
        <div class="card-body">
            <form action="/kategori" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                            <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}">
                            @error('nama_kategori')
                            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="DeskripsiProduk" name="deskripsi" value="{{ old('deskripsi') }}"
                            id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">DeskripsiProduk</label>
                        @error('deskripsi')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-8" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Data Produk</div>
        <div class="card-body">
            <form action="/produk" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk_" class="form-control" value="{{ old('nama_produk_') }}">
                            @error('nama_produk_')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Harga Produk</label>
                            <input type="number" name="harga" class="form-control" value="{{ old('harga') }}">
                            @error('harga')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Stok Produk</label>
                            <input type="number" name="stok" class="form-control" value="{{ old('stok') }}">
                            @error('stok')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kategori Produk</label>
                            <select class="form-select" aria-label="Default select example" name="kategori">
                                <option value="">-- Pilih Disini --</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                                @error('kategori')
                                    <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="DeskripsiProduk" name="deskripsi_produk"
                            value="{{ old('deskripsi_produk') }}" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Deskripsi Produk</label>
                        @error('deskripsi_produk')
                            <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
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
@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">Edit Produk</div>
        <div class="card-body">
            <form action="/produk/{{ $data->id_produk }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk_" class="form-control" value="{{ $data->nama_produk }}">
                            @error('nama_produk_')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Harga Produk</label>
                            <input type="number" name="harga_produk" class="form-control" value="{{ $data->harga }}">
                            @error('harga_produk')
                                <div id="emailHelp" class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Stok Produk</label>
                            <input type="number" name="stok" class="form-control" value="{{ $data->stok }}">
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
                                @foreach($data_kategori as $item)
                                    <option value="{{ $item->id_kategori }}">
                                        {{ $item->nama_kategori }}
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
                    <label for="exampleInputEmail1" class="form-label">Deskripsi Produk</label>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="DeskripsiProduk" name="deskripsi_produk"
                            id="floatingTextarea2" style="height: 100px"> {{ $data->deskripsi_produk }} </textarea>
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
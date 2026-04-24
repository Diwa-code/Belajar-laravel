@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">Edit Kategori</div>
        <div class="card-body">
            <form action="/kategori/{{ $data_kategori->id_kategori }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" value="{{ $data_kategori->nama_kategori }}">
                            @error('nama_kategori')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label for="deskripsi" class="form-label">Deskripsi Kategori</label>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Deskripsi Kategori" name="deskripsi" 
                            id="floatingTextarea2" style="height: 100px">{{ $data_kategori->deskripsi }}</textarea>
                        @error('deskripsi')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-8" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/kategori" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
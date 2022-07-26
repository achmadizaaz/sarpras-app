@extends('layouts.master')

@section('title', 'Edit Building')

@section('main-content')

    <section class="section">
        <div class="section-header">
        <h1><span class="text-primary">Edit</span> {{ $building->name }}</h1>
        </div>
        <div class="section-body">
            
            <div class="row">
                <div class="col-7">
                <div class="card border">
                    <form action="{{ route('building.update', $building->slug) }}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode address</label>
                            <input type="text" class="form-control" name="kode" id="kode" value="{{ $building->code }}" readonly>
                          </div>
                          <div class="mb-3">
                            <label for="name" class="form-label">Nama Gedung</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $building->name) }}">
                          </div>
                          <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="1" 
                                        @if ($building->status == 1)selected @endif>
                                        Active
                                    </option>
                                    <option value="1" 
                                    @if ($building->status == 0)selected  @endif>
                                        Not Active
                                    </option>
                                </select>
                          </div>
                          <div class="text-end">
                            <a class="btn btn-danger" href="{{ route('building.index') }}">Cancel</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                          </div>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </section>

    
@endsection
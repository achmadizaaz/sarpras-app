@extends('layouts.master')

@section('title', 'Building')

@section('main-content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
      <h1>Gedung</h1>
    </div>
    <div class="section-body">
        
        @if (session('success'))
            {{-- <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> --}}
                {{-- Sweetalert Sukses --}}
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: '<?php echo session('success') ?>',
                    showConfirmButton: true,
                    timer: 3000,
                    timerProgressBar: true,
                })
            </script>
        @endif
       
        
          <div class="row">
            <div class="col-12">
            <div class="card border rounded-5">
                <div class="card-header justify-content-between">
                    <h4>List Gedung</h4>
                    <div class="d-flex">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-gedung">
                            Tambah
                          </button>
                    </div>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                    <tbody>
                        <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Gedung</th>
                        <th>Status</th>
                        <th>Dibuat pada</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($building as $build)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $build->code }}</td>
                        <td>{{ $build->name }}</td>
                        <td>
                            @if ($build->status == 1)
                            <div class="badge badge-success">Active</div>
                            @else
                            <div class="badge badge-danger">Not Active</div>
                            @endif  
                        </td>
                        <td>{{ $build->created_at}}</td>
                        <td>
                            <a href="{{ route('building.edit', $build->slug) }}" class="btn btn-icon btn-warning">
                                <i class="far fa-edit"></i>
                            </a>

                            <form action="{{route('building.destroy', $build->id)}}" class="d-inline" method="post">
                            @csrf
                            @method('delete')
                                <button class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus')"><i class="fas fa-trash"></i></button>
                            </form>
                           
                            <button class="btn btn-danger btn-flat btn-sm remove-user" data-id="{{ $build->id }}" data-action="{{ route('building.destroy', $build->id) }}" onclick="deleteConfirmation({{$build->id}})"> Delete</button>
                            
                            
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
</td> 
</section>
 
  <!-- Modal Tambah Gedung -->
  <div class="modal fade" id="modal-gedung" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <span class="text-primary">Tambah</span> Gedung</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('building.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="code" class="form-label">Kode</label>
                    <input class="form-control" type="text" id="code" name="code" value="{{ $lastCode }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input class="form-control" type="text" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script type="text/javascript">
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: "/dashboard/building/" + id,
                data: {
                        "id": id,
                        "_token": CSRF_TOKEN,
                        "_method":"DELETE"
                        },
                dataType: 'JSON',
                success: function (results) {
                   
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                   
                    
                }
            })
            
      }
    })
                  
    }



    
</script>
@endsection


@extends('baseLayout.index')
@push('css')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('content')
    @php
        $method = 'POST';
        $url_action = url($base_url);
        if (!empty($data)) {
            $url_action = url($base_url)."/$data->uuid";
        } else {
            $data = null;
        }
    @endphp
        <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div> --}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">&nbsp;</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form method="{{ $method }}" enctype="multipart/form-data"
                                              action="{{ $url_action }}" id="formArticle">
                                            @csrf
                                            @if(!empty($data))
                                                @method('put')
                                            @endif
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="title">Region</label>
                                                    <select class="js-select2" name="region" required>
                                                        @foreach ($region as $item)
                                                            @php
                                                                $selected = '';
                                                                if($item->id == ($data->region_id ?? null)){
                                                                    $selected = 'selected';
                                                                }
                                                            @endphp
                                                            <option value="{{ $item->id }}" {{ $selected }} > {{$item->nama}} </option>
                                                        @endforeach
                                                    </select>
                                                    @if (session('validator')['region'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['region'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Tipe Kantor</label>
                                                    <select class="js-select2" name="tipe_kantor" required>
                                                        @foreach ($tipe_kantor as $item)
                                                            @php
                                                                $selected = '';
                                                                if($item == ($data->tipe_kantor ?? null)){
                                                                    $selected = 'selected';
                                                                }
                                                            @endphp
                                                            <option value="{{ $item }}" {{ $selected }} > {{$item}} </option>
                                                        @endforeach
                                                    </select>
                                                    @if (session('validator')['tipe_kantor'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['tipe_kantor'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Nama</label>
                                                    <input type="text" class="form-control" id="nama" name="nama"
                                                           required value="{{ $data->nama ?? null ?? old('nama') }}">
                                                    @if (session('validator')['nama'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['nama'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Alamat</label>
                                                    <textarea class="form-control" id="alamat" name="alamat" required>{{ $data->alamat ?? null ?? old('alamat') }}</textarea>
                                                    @if (session('validator')['alamat'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['alamat'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- /.card-body -->

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary" >Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

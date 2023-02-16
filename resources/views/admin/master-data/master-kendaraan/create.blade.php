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
                                              action="{{ $url_action }}">
                                            @csrf
                                            @if(!empty($data))
                                                @method('put')
                                            @endif
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="title">Status Kendaraan</label>
                                                    <select class="js-select2" name="status_kendaraan" required>
                                                        @foreach ($status_kendaraan as $item)
                                                            @php
                                                                $selected = '';
                                                                if($item == ($data->status_kendaraan ?? null) || $item == old('status_kendaraan')){
                                                                    $selected = 'selected';
                                                                }
                                                            @endphp
                                                            <option value="{{ $item }}" {{ $selected }} > {{$item}} </option>
                                                        @endforeach
                                                    </select>
                                                    @if (session('validator')['status_kendaraan'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['status_kendaraan'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="title">Jenis Kendaraan</label>
                                                    <select class="js-select2-tags" name="jenis_kendaraan" required>
                                                        @if(!empty(old('jenis_kendaraan')))
                                                            <option value="{{old('jenis_kendaraan')}}" selected>{{old('jenis_kendaraan')}}</option>
                                                        @endif
                                                        @foreach ($jenis_kendaraan as $item)
                                                            @php
                                                                $selected = '';
                                                                if($item == ($data->jenis_kendaraan ?? null)){
                                                                    $selected = 'selected';
                                                                }
                                                            @endphp
                                                            <option value="{{ $item }}" {{ $selected }} > {{$item}} </option>
                                                        @endforeach
                                                    </select>
                                                    @if (session('validator')['jenis_kendaraan'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['jenis_kendaraan'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="title">Agen Sewa</label>
                                                    <select class="js-select2-tags" name="agen_sewa" required>
                                                        @if(!empty(old('agen_sewa')))
                                                            <option value="{{old('agen_sewa')}}" selected>{{old('agen_sewa')}}</option>
                                                        @endif
                                                        @foreach ($agen_sewa as $item)
                                                            @php
                                                                $selected = '';
                                                                if($item == ($data->agen_sewa ?? null)){
                                                                    $selected = 'selected';
                                                                }
                                                            @endphp
                                                            <option value="{{ $item }}" {{ $selected }} > {{$item}} </option>
                                                        @endforeach
                                                    </select>
                                                    @if (session('validator')['agen_sewa'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['agen_sewa'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="title">Tanggal Sewa Start</label>
                                                    <input type="date" class="form-control" id="tanggal_sewa_start_at" name="tanggal_sewa_start_at" value="{{ $data->tanggal_sewa_start_at ?? null ?? old('tanggal_sewa_start_at') }}">
                                                    @if (session('validator')['tanggal_sewa_start_at'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['tanggal_sewa_start_at'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Tanggal Sewa End</label>
                                                    <input type="date" class="form-control" id="tanggal_sewa_end_at" name="tanggal_sewa_end_at" value="{{ $data->tanggal_sewa_end_at ?? null ?? old('tanggal_sewa_end_at') }}">
                                                    @if (session('validator')['tanggal_sewa_end_at'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['tanggal_sewa_end_at'] as $item)
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

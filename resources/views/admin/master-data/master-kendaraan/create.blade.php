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
                                                    <label for="title">Nama</label>
                                                    <input type="text" class="form-control" name="nama" value="{{ $data->nama ?? old('nama') ?? null }}" required>
                                                    @if (session('validator')['nama'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['nama'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Max Tangki</label>
                                                    <input type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" class="form-control" name="max_tangki" value="{{ $data->max_tangki ?? old('max_tangki') ?? null }}" required>
                                                    @if (session('validator')['max_tangki'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['max_tangki'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Current KM</label>
                                                    <input type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" class="form-control" name="current_km" value="{{ $data->current_km ?? old('current_km') ?? null }}" required>
                                                    @if (session('validator')['current_km'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['current_km'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

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

                                                <div class="form-group form-sewa">
                                                    <label for="title">Agen Sewa</label>
                                                    <select class="js-select2-tags" name="agen_sewa">
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

                                                <div class="form-group form-sewa">
                                                    <label for="title">Tanggal Beli / Sewa Start</label>
                                                    <input type="datetime-local" class="form-control" id="tanggal_beli_sewa_at" name="tanggal_beli_sewa_at" value="{{ \Carbon\Carbon::parse($data->tanggal_beli_sewa_at ?? now()) ?? null ?? old('tanggal_beli_sewa_at') }}">
                                                    @if (session('validator')['tanggal_beli_sewa_at'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['tanggal_beli_sewa_at'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group form-sewa">
                                                    <label for="title">Tanggal Beli / Sewa End</label>
                                                    <input type="datetime-local" class="form-control" id="tanggal_jual_sewa_at" name="tanggal_jual_sewa_at" value="{{ \Carbon\Carbon::parse($data->tanggal_jual_sewa_at ?? now()) ?? null ?? old('tanggal_jual_sewa_at') }}">
                                                    @if (session('validator')['tanggal_jual_sewa_at'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['tanggal_jual_sewa_at'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                @if(!empty($data))
                                                    <div class="form-group form-sewa">
                                                        <label for="title">Status</label>
                                                        <select class="js-select2-tags" name="status">
                                                            @if(!empty(old('status')))
                                                                <option value="{{old('status')}}" selected>{{old('status')}}</option>
                                                            @endif
                                                            @foreach ($status as $key => $item)
                                                                @php
                                                                    $selected = '';
                                                                    if($key == ($data->status ?? null)){
                                                                        $selected = 'selected';
                                                                    }
                                                                @endphp
                                                                <option value="{{ $key }}" {{ $selected }} > {{$item}} </option>
                                                            @endforeach
                                                        </select>
                                                        @if (session('validator')['status'] ?? null)
                                                            <div class="invalid-feedback" style="display: inline;">
                                                                @foreach (session('validator')['status'] as $item)
                                                                    {{ $item }} <br>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

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

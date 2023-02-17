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
                                                    <label for="title">Kendaraan</label>
                                                    <select class="js-select2" name="master_kendaraan_id" required>
                                                        @foreach ($kendaraan as $item)
                                                            @php
                                                                $selected = '';
                                                                if($item->id == ($data->master_kendaraan_id ?? null)){
                                                                    $selected = 'selected';
                                                                }
                                                            @endphp
                                                            <option value="{{ $item->id }}" {{ $selected }} > {{$item->attr_detail_kendaraan}} </option>
                                                        @endforeach
                                                    </select>
                                                    @if (session('validator')['master_kendaraan_id'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['master_kendaraan_id'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label for="title">Tanggal Service</label>
                                                    <input type="datetime-local" class="form-control" id="tanggal_service_at" name="tanggal_service_at"
                                                           required value="{{ $data->tanggal_service_at ?? null ?? old('tanggal_service_at') }}">
                                                    @if (session('validator')['tanggal_service_at'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['tanggal_service_at'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" required>{{ $data->keterangan ?? null ?? old('keterangan') }}</textarea>
                                                    @if (session('validator')['keterangan'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['keterangan'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Bukti Service</label>
                                                    <input type="file" name="bukti_struk" class="form-control">
                                                    @if (session('validator')['bukti_struk'] ?? null)
                                                        <div class="invalid-feedback" style="display: inline;">
                                                            @foreach (session('validator')['bukti_struk'] as $item)
                                                                {{ $item }} <br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    <br>
                                                    @if(!empty($data))
                                                        <a href="{{ imageExists($data->bukti_struk) }}" target="_blank"> <small> Lihat File </small> </a>
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

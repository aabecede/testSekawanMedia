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
                                                @include('admin.pemesanan.components.edit')
                                              @else
                                                @include('admin.pemesanan.components.create')
                                              @endif

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
@push('js')
    <script>
        function dataDriver(){
            let tanggal_berangkat = $('[name="tanggal_keberangkatan_at"]').val();
            let tanggal_pulang = $('[name="tanggal_pulang_at"]').val();

            console.log(`tanggal_berangkat : ${tanggal_berangkat}`, ` tanggal_pulang : ${tanggal_pulang}`)

            let driverSelect = $(".select2-driver")
            let kendaraanSelect = $(".select2-kendaraan")

            kendaraanSelect.empty()
            $.ajax({
                type: 'GET',
                url: `${BASE_URL}/admin/master-data/kendaraan-pemesanan-avilable`,
                data : {
                    tanggal_berangkat,
                    tanggal_pulang
                },
                dataType: 'json',
            }).then(function (response) {
                console.log(response.data);

                if(response.code == 200){
                    $.each(response?.data, function (key, value) {
                        var text = `${value?.attr_detail_kendaraan}`;
                        var newOption = new Option(text, value?.id, false, false);
                        kendaraanSelect.append(newOption).trigger('change');
                    });

                }
            });

            driverSelect.empty()
            $.ajax({
                type: 'GET',
                url: `${BASE_URL}/admin/master-data/pegawai-driver-pemesanan-avilable`,
                data : {
                    tanggal_berangkat,
                    tanggal_pulang
                },
                dataType: 'json',
            }).then(function (response) {
                console.log(response.data);

                if(response.code == 200){
                    $.each(response?.data, function (key, value) {
                        var text = `${value?.attr_user_jabatan}`;
                        var newOption = new Option(text, value?.id, false, false);
                        driverSelect.append(newOption).trigger('change');
                    });

                }
            });
        }
    </script>
@endpush

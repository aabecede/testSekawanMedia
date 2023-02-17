@extends('baseLayout.index')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3 text-right">
                                    @if(auth()->user()->attr_is_admin)
                                        <a href="{{ url()->current().'/create' }}" class="btn btn-primary">New Data</a>
                                    @endif
                                </div>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">Orang yang mengajukan</th>
                                    <th class="text-center">Detail Kendaraan</th>
                                    <th class="text-center" width="35%">Detail Penggunaan</th>
                                    <th class="text-center">Penyetuju</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($data as $key => $item)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-left">
                                            Nama : <span class="badge badge-primary">{{$item->user_pengaju->name}} </span> <br>
                                            Jabatan : <span class="badge badge-info">{{$item->user_pengaju->jabatan}}</span><br>
                                        </td>
                                        <td class="text-left">
                                            Nama : <span class="badge badge-primary"> {{$item->master_kendaraan->nama}} </span> <br>
                                            Jenis Kendaraan : <span class="badge badge-primary"> {{$item->master_kendaraan->jenis_kendaraan}} </span> <br>
                                            Status Kepemilikan : <span class="badge badge-warning"> {{$item->master_kendaraan->status_kendaraan}} </span> <br>
                                            KM Start : <span class="badge badge-dark"> {{$item->km_start ?? 'Belum Diisi'}} </span> <br>
                                            KM End : <span class="badge badge-danger"> {{$item->km_end ?? 'Belum Diisi'}} </span> <br>
                                        </td>
                                        <td class="text-left">
                                            Jadwal Penggunaan : <span class="badge badge-warning">{{ $item->attr_tanggal_penggunaan_format }}</span> <br>
                                            Driver : <span class="badge badge-success">{{ $item->user_driver->name }}</span> <br>
                                            <span class="badge badge-info">Keterangan :</span><br>
                                            {{ cutText($item->keterangan,40) }}
                                        </td>
                                        <td class="text-left">
                                            Penyetuju 1 : <span class="badge badge-info">{{ $item->user_penyetuju_1->name  }}</span><br>
                                            Status Penyetuju 1 : {!! $item->attr_status_penyetuju_badge  !!}<br>
                                            Penyetuju 2 : <span class="badge badge-primary">{{ $item->user_penyetuju_2->name  }}</span><br>
                                            Status Penyetuju 1 : {!! $item->attr_status_penyetuju2_badge  !!}<br>
                                        </td>
                                        <td>
                                            @if(auth()->user()->attr_is_admin)
                                                {{-- <a class="btn btn-primary"
                                                href="{{ url()->current() }}/{{ $item->uuid }}">
                                                    Detail
                                                </a> --}}
                                                <a class="btn btn-warning"
                                                href="{{ url()->current() }}/{{ $item->uuid }}/edit">
                                                    Edit
                                                </a>
                                                <button class="btn btn-danger" id="btnDeleteArticle"
                                                        data-id="{{ $item->uuid }}" type="button">
                                                    Delete
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No Data</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {!! $data->links() !!}
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
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).on('click', '#btnDeleteArticle', function() {
            let id = $(this).data('id')
            let this_button = $(this)
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
                    $.ajax({
                        type: "DELETE",
                        url: `{{url()->current()}}/${id}`,
                        dataType: "json",
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            if (response.code == 200) {
                                window.location.href = response.url
                            }

                        },
                        error: function(response) {
                            $('#main-page-loading').css('display', 'none')
                            $("#loading-button").remove()
                            $(this_button).attr('disabled', false)
                            // console.log(response.responseJSON.code)
                            if (response.responseJSON.code == 400) {
                                return validatorMessageJs({
                                    message: response.responseJSON.message
                                });
                            } else {
                                return swalTerjadiKesalahanServer()
                            }
                        }
                    });
                }
            })
        })
    </script>
@endpush

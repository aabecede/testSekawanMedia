@extends('baseLayout.index')
@section('content')
    @php
        $arr_select_data = explode(',', $selected_data);
    @endphp
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3 text-right">
                                    <a href="{{ url()->current().'/create' }}" class="btn btn-primary">New Data</a>
                                </div>
                            </div>
                            <div style="overflow-x: auto;">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">Tipe Kendaran</th>
                                        <th class="text-center">Status Kendaran</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($data as $key => $item)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td class="text-left">
                                                Jenis Kendaraan : <span class="badge badge-info"> {{ $item->jenis_kendaraan }} </span><br>
                                                @if($item->status_kendaraan == 'SEWA')
                                                    Status Kendaraan : <span class="badge badge-primary"> {{ $item->status_kendaraan }} </span><br>
                                                    Agency : <span class="badge badge-dark"> {{ $item->agen_sewa }} </span><br>
                                                    Tanggal Sewa Start : <span class="badge badge-info"> {{ $item->tanggal_beli_sewa_at }} </span><br>
                                                    Tanggal Sewa End : <span class="badge badge-info"> {{ $item->tanggal_jual_sewa_at }} </span><br>
                                                @else
                                                    Status Kendaraan : <span class="badge badge-success"> {{ $item->status_kendaraan }} </span><br>
                                                    Tanggal Beli : <span class="badge badge-info"> {{ $item->tanggal_beli_sewa_at }} </span><br>
                                                    Tanggal Jual : <span class="badge badge-info"> {{ $item->tanggal_jual_sewa_at }} </span><br>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $badge = 'success';
                                                    if($item->status == -1){
                                                        $badge = 'danger';
                                                    }
                                                @endphp
                                                Kendaraan : <span class="badge badge-info"> {{ $item->nama }} </span><br>
                                                Max Tankgki : <span class="badge badge-info"> {{ $item->max_tangki }} </span><br>
                                                Current KM : <span class="badge badge-info"> {{ $item->current_km }} </span><br>
                                                Status : <span class="badge badge-{{$badge}}"> {{ $item->attr_status }} </span><br>
                                            </td>
                                            <td>
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
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="0">No Data</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
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

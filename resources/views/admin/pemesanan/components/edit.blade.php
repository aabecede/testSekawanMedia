<div class="card-body">
    <small class="badge badge-info">Petunjuk pengisian : Silahkan Isi tanggal berangkat & tanggal Pulang untuk melihat
        Driver dan Kendaraan yang tersedia</small>
    <div class="form-group">
        <label for="title">User Pengaju</label>
        <select class="js-select2" name="user_id" required>
            @foreach ($pengaju as $item)
                @php
                    $selected = '';
                    if ($item->id == ($data->user_id ?? null)) {
                        $selected = 'selected';
                    }
                @endphp
                <option value="{{ $item->id }}" {{ $selected }}> {{ $item->name }} </option>
            @endforeach
        </select>
        @if (session('validator')['user_id'] ?? null)
            <div class="invalid-feedback" style="display: inline;">
                @foreach (session('validator')['user_id'] as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif
    </div>


    <div class="form-group">
        <label for="title">Tanggal Berangkat</label>
        <input type="datetime-local" id="tanggal_keberangkatan_at" name="tanggal_keberangkatan_at" class="form-control" value="{{ $data->tanggal_keberangkatan_at }}" onchange="dataDriver()">
        @if (session('validator')['tanggal_keberangkatan_at'] ?? null)
            <div class="invalid-feedback" style="display: inline;">
                @foreach (session('validator')['tanggal_keberangkatan_at'] as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="title">Tanggal Pulang</label>
        <input type="datetime-local" id="tanggal_pulang_at" name="tanggal_pulang_at" class="form-control" value="{{ $data->tanggal_pulang_at }}" onchange="dataDriver()">
        @if (session('validator')['tanggal_pulang_at'] ?? null)
            <div class="invalid-feedback" style="display: inline;">
                @foreach (session('validator')['tanggal_pulang_at'] as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif
    </div>


    <div class="form-group">
        <label for="title">Penyetuju 1</label>
        <select class="js-select2" name="penyetuju" required>
            @foreach ($penyetuju as $item)
                @php
                    $selected = '';
                    if ($item->id == ($data->penyetuju ?? null)) {
                        $selected = 'selected';
                    }
                @endphp
                <option value="{{ $item->id }}" {{ $selected }}> {{ $item->name }} </option>
            @endforeach
        </select>
        @if (session('validator')['penyetuju'] ?? null)
            <div class="invalid-feedback" style="display: inline;">
                @foreach (session('validator')['penyetuju'] as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif
    </div>
    <div class="form-group">
        <label for="title">Penyetuju 2</label>
        <select class="js-select2" name="penyetuju2" required>
            @foreach ($penyetuju as $item)
                @php
                    $selected = '';
                    if ($item->id == ($data->penyetuju2 ?? null)) {
                        $selected = 'selected';
                    }
                @endphp
                <option value="{{ $item->id }}" {{ $selected }}> {{ $item->name }} </option>
            @endforeach
        </select>
        @if (session('validator')['penyetuju2'] ?? null)
            <div class="invalid-feedback" style="display: inline;">
                @foreach (session('validator')['penyetuju2'] as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="title">Driver</label>
        <select class="js-select2 select2-driver" name="driver" required>
            <option value="{{ $data->driver }}" selected> {{ $data->user_driver->attr_user_jabatan }}  </option>
        </select>
        @if (session('validator')['driver'] ?? null)
            <div class="invalid-feedback" style="display: inline;">
                @foreach (session('validator')['driver'] as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="title">Kendaraan</label>
        <select class="js-select2 select2-kendaraan" name="master_kendaraan_id" required>
            <option value="{{ $data->master_kendaraan_id }}" selected> {{ $data->master_kendaraan->attr_detail_kendaraan }} </option>
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
        <label for="title">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" required>{{ $data->keterangan ?? (null ?? old('keterangan')) }}</textarea>
        @if (session('validator')['keterangan'] ?? null)
            <div class="invalid-feedback" style="display: inline;">
                @foreach (session('validator')['keterangan'] as $item)
                    {{ $item }} <br>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="title">Name</label>
    <input type="text" class="form-control" name="name" value="{{ $data->name ?? (old('name') ?? null) }}">
    @if (session('validator')['name'] ?? null)
        <div class="invalid-feedback" style="display: inline;">
            @foreach (session('validator')['name'] as $item)
                {{ $item }} <br>
            @endforeach
        </div>
    @endif
</div>

<div class="form-group">
    <label for="title">Email</label>
    <input type="text" class="form-control" name="email" value="{{ $data->email ?? (old('email') ?? null) }}">
    @if (session('validator')['email'] ?? null)
        <div class="invalid-feedback" style="display: inline;">
            @foreach (session('validator')['email'] as $item)
                {{ $item }} <br>
            @endforeach
        </div>
    @endif
</div>

<div class="form-group">
    <label for="title">Region</label>
    <select class="js-select2" name="master_region_id">
        <option value="" selected> Tanpa Region </option>
        @foreach ($region as $item)
            @php
                $selected = '';
                if ($item->id == ($data->master_region_id ?? null)) {
                    $selected = 'selected';
                }
            @endphp
            <option value="{{ $item->id }}" {{ $selected }}> {{ $item->nama }} </option>
        @endforeach
    </select>
    @if (session('validator')['master_region_id'] ?? null)
        <div class="invalid-feedback" style="display: inline;">
            @foreach (session('validator')['master_region_id'] as $item)
                {{ $item }} <br>
            @endforeach
        </div>
    @endif
</div>

<div class="form-group">
    <label for="title">Jabatan</label>
    <select class="js-select2" name="jabatan" required>
        @foreach ($jabatan as $item)
            @php
                $selected = '';
                if ($item == ($data->jabatan ?? null)) {
                    $selected = 'selected';
                }
            @endphp
            <option value="{{ $item }}" {{ $selected }}> {{ $item }} </option>
        @endforeach
    </select>
    @if (session('validator')['jabatan'] ?? null)
        <div class="invalid-feedback" style="display: inline;">
            @foreach (session('validator')['jabatan'] as $item)
                {{ $item }} <br>
            @endforeach
        </div>
    @endif
</div>

<div class="form-group">
    <label for="title">Role</label>
    <select class="js-select2" name="role" required>
        @foreach ($role as $item)
            @php
                $selected = '';
                if ($item == ($data->role ?? null)) {
                    $selected = 'selected';
                }
            @endphp
            <option value="{{ $item }}" {{ $selected }}> {{ $item }} </option>
        @endforeach
    </select>
    @if (session('validator')['role'] ?? null)
        <div class="invalid-feedback" style="display: inline;">
            @foreach (session('validator')['role'] as $item)
                {{ $item }} <br>
            @endforeach
        </div>
    @endif
</div>

<div class="form-group">
    <label for="title">Status</label>
    <select class="js-select2" name="status" required>
        @foreach ($status as $item)
            @php
                $selected = '';
                if ($item == ($data->status ?? null)) {
                    $selected = 'selected';
                }
            @endphp
            <option value="{{ $item }}" {{ $selected }}> {{ $item }} </option>
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

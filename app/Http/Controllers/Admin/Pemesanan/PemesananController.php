<?php

namespace App\Http\Controllers\Admin\Pemesanan;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePemesananRequest;
use App\Http\Requests\UpdatePemesananRequest;
use App\Models\MasterKendaraan;
use App\Models\User;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $select = '*'; #untuk selectnya
    protected $base_url = 'admin/pemesanan'; #base url routenya
    public function index()
    {
        $base_url = $this->base_url;
        $data = Pemesanan::with([
            'user_penyetuju_1:id,name,jabatan',
            'user_penyetuju_2:id,name,jabatan',
            'user_driver:id,name,jabatan',
            'master_kendaraan:id,nama,status_kendaraan,jenis_kendaraan,current_km,max_tangki',
            'user_pengaju:id,name,jabatan'
        ])
            ->paginate(10);
        return view('admin.pemesanan.index', compact(
            'base_url',
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('isAdmin');
        $base_url = $this->base_url;
        $penyetuju = User::jabatanKepala()->selectRaw('id,name')->get();
        $pengaju = User::notDriver()->selectRaw('id,name')->get();
        return view('admin.pemesanan.create', compact(
            'base_url',
            'penyetuju',
            'pengaju',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePemesananRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePemesananRequest $request)
    {
        $this->middleware('isAdmin');
        DB::beginTransaction();
        try {
            // dd($request->all());
            $kendaraan = MasterKendaraan::selectRaw('current_km')->find($request->master_kendaraan_id);
            $data = [
                'user_id' => $request->user_id,
                'master_kendaraan_id' => $request->master_kendaraan_id,
                'keterangan' => $request->keterangan,
                'penyetuju' => $request->penyetuju,
                'driver' => $request->driver,
                'penyetuju2' => $request->penyetuju2,
                'tanggal_keberangkatan_at' => $request->tanggal_keberangkatan_at,
                'tanggal_pulang_at' => $request->tanggal_pulang_at,
                'km_start' => $kendaraan->current_km,
            ];

            Pemesanan::create($data);
            DB::commit();
            return redirect($this->base_url)->withSuccess('Data Saved');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function show(Pemesanan $pemesanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function edit(String $pemesanan)
    {
        $this->middleware('isAdmin');
        $data = Pemesanan::with([
            'user_penyetuju_1:id,name,jabatan',
            'user_penyetuju_2:id,name,jabatan',
            'user_pengaju:id,name,jabatan',
            'user_driver:id,name,jabatan',
            'master_kendaraan:id,nama,status_kendaraan,jenis_kendaraan,current_km,max_tangki',
        ])->whereUuid($pemesanan)->first();
        $base_url = $this->base_url;
        $penyetuju = User::jabatanKepala()->selectRaw('id,name')->get();
        $pengaju = User::notDriver()->selectRaw('id,name')->get();
        return view('admin.pemesanan.create', compact(
            'base_url',
            'data',
            'penyetuju',
            'pengaju',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePemesananRequest  $request
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePemesananRequest $request, String $pemesanan)
    {
        $this->middleware('isAdmin');
        DB::beginTransaction();
        $model = Pemesanan::whereUuid($pemesanan)->first();
        if(in_array($model->status, [1,2,3])){
            return back()->withInput()->withError('Pemesanan Disetujui Tidak bisa Dirubah');
        }
        try {
            $kendaraan = MasterKendaraan::selectRaw('current_km')->find($request->master_kendaraan_id);
            $data = [
                'user_id' => $request->user_id,
                'master_kendaraan_id' => $request->master_kendaraan_id,
                'keterangan' => $request->keterangan,
                'penyetuju' => $request->penyetuju,
                'driver' => $request->driver,
                'penyetuju2' => $request->penyetuju2,
                'tanggal_keberangkatan_at' => $request->tanggal_keberangkatan_at,
                'tanggal_pulang_at' => $request->tanggal_pulang_at,
                'km_start' => $kendaraan->current_km,
            ];
            // dd($data);
            $model->update($data);
            DB::commit();
            return redirect($this->base_url)->withSuccess('Data Changed');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $pemesanan)
    {
        $this->middleware('isAdmin');
        try {
            DB::beginTransaction();
            $model = Pemesanan::whereUuid($pemesanan)->first();
            if (empty($model)) {
                return $this->errorJson();
            }
            $model->delete();
            $result = [
                'url' => url($this->base_url)
            ];
            DB::commit();
            return $this->successJson($result);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->exceptionJson($th);
        }
    }
}

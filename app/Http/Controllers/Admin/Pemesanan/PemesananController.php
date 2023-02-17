<?php

namespace App\Http\Controllers\Admin\Pemesanan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pemesanan\KonfirmasiPenyetujuRequest;
use App\Http\Requests\Admin\Pemesanan\UbahStatusJalanRequest;
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
        $status_penyetuju = Pemesanan::$status_penyetuju;
        return view('admin.pemesanan.index', compact(
            'base_url',
            'data',
            'status_penyetuju'
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
            return back()->withInput()->withError('Pemesanan Telah Disetujui / Selesai');
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
            if (in_array($model->status, [1, 2, 3])) {
                return $this->errorJson([], 'Pemesanan Telah Disetujui / Selesai');
            }
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

    public function konfirmasiPenyetuju(KonfirmasiPenyetujuRequest $request)
    {
        DB::beginTransaction();
        try {
            $base_pemesanan = Pemesanan::whereUuid($request->uuid);
            if($request->penyetuju == 1){
                $pemesanan = with(clone $base_pemesanan)->where('penyetuju', $request->penyetuju_id);
                $data = [
                    'status_penyetuju' => $request->status_penyetuju,
                    'status_alasan_penyetuju' => $request->alasan_penyetuju,
                ];
            }
            elseif($request->penyetuju == 2){
                $pemesanan = with(clone $base_pemesanan)->where('penyetuju2', $request->penyetuju_id);
                $data = [
                    'status_penyetuju2' => $request->status_penyetuju,
                    'status_alasan_penyetuju2' => $request->alasan_penyetuju,
                ];
            }
            else{
                return $this->errorJson();
            }
            $update_pemesanan = $pemesanan->update($data);
            $pemesanan = with(clone $base_pemesanan)->first();

            //update status
            if($pemesanan->status_penyetuju == 1 && $pemesanan->status_penyetuju2 == 1){
                $data = [
                    'status' => 1
                ];
            }
            elseif ($pemesanan->status_penyetuju == -1 && $pemesanan->status_penyetuju2 == -1) {
                $data = [
                    'status' => -1
                ];
            }
            $pemesanan->update($data);
            $result = [
                'url' => url($this->base_url)
            ];
            DB::commit();
            return $this->successJson($result);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->exceptionJson($th);
        }
    }

    public function ubahStatusJalan(UbahStatusJalanRequest $request){
        DB::beginTransaction();
        try {
            $pemesanan = Pemesanan::whereUuid($request->uuid)->first();

            if(in_array($pemesanan->status, [1,2,3])){
                if ($pemesanan->status == 3) {
                    return $this->errorJson([], 'Status sudah selesai');
                }
                $pemesanan->status += 1;
            }else{
                return $this->errorJson([], 'Status Tidak Ditemukan');
            }
            $pemesanan->updated_by = auth()->id();
            $pemesanan->save();

            DB::commit();
            $result = [
                'url' => url($this->base_url)
            ];
            return $this->successJson($result);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->exceptionJson($th);
        }
    }
}

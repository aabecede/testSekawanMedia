<?php

namespace App\Http\Controllers\Admin\MasterData\Kendaraan;

use App\Http\Controllers\Controller;
use App\Models\MasterKendaraan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMasterKendaraanRequest;
use App\Http\Requests\UpdateMasterKendaraanRequest;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $select = 'uuid,jenis_kendaraan,status_kendaraan,agen_sewa,tanggal_beli_sewa_at,tanggal_jual_sewa_at,status,max_tangki,current_km,nama'; #untuk selectnya
    protected $base_url = 'admin/master-data/kendaraan'; #base url routenya
    public function index()
    {
        $base_url = $this->base_url;
        $selected_data = $this->select;
        $data = (new KendaraanRead())->paginateMasterKendaraan(10, $selected_data);
        return view('admin.master-data.master-kendaraan.index', compact(
            'base_url',
            'data',
            'selected_data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $base_url = $this->base_url;
        $status_kendaraan = MasterKendaraan::$status_kendaraan;
        $jenis_kendaraan = MasterKendaraan::groupByTipe('jenis_kendaraan')->get()->pluck('jenis_kendaraan')->toArray();
        $agen_sewa = MasterKendaraan::groupByTipe('agen_sewa')->get()->pluck('agen_sewa')->toArray();

        return view('admin.master-data.master-kendaraan.create', compact(
            'base_url',
            'status_kendaraan',
            'jenis_kendaraan',
            'agen_sewa'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasterKendaraanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterKendaraanRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = [
                'status_kendaraan' => $request->status_kendaraan,
                'jenis_kendaraan' => strtoupper($request->jenis_kendaraan),
                'tanggal_beli_sewa_at' => $request->tanggal_beli_sewa_at,
                'current_km' => $request->current_km,
                'max_tangki' => $request->max_tangki,
                'nama' => $request->nama
            ];
            if(strtoupper($request->status_kendaraan) == 'SEWA'){
                $data['agen_sewa'] = strtoupper($request->agen_sewa);
                $data['tanggal_jual_sewa_at'] = $request->tanggal_jual_sewa_at;
            }
            // dd($data, $request->all());
            MasterKendaraan::create($data);
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
     * @param  \App\Models\MasterKendaraan  $masterKendaraan
     * @return \Illuminate\Http\Response
     */
    public function show(MasterKendaraan $masterKendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterKendaraan  $masterKendaraan
     * @return \Illuminate\Http\Response
     */
    public function edit(String $masterKendaraan)
    {
        $data = MasterKendaraan::whereUuid($masterKendaraan)->first();
        $base_url = $this->base_url;
        $status_kendaraan = MasterKendaraan::$status_kendaraan;
        $jenis_kendaraan = MasterKendaraan::groupByTipe('jenis_kendaraan')->get()->pluck('jenis_kendaraan')->toArray();
        $agen_sewa = MasterKendaraan::groupByTipe('agen_sewa')->get()->pluck('agen_sewa')->toArray();
        $status = MasterKendaraan::$status;
        return view('admin.master-data.master-kendaraan.create', compact(
            'base_url',
            'data',
            'status_kendaraan',
            'jenis_kendaraan',
            'agen_sewa',
            'status'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterKendaraanRequest  $request
     * @param  \App\Models\MasterKendaraan  $masterKendaraan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterKendaraanRequest $request, String $masterKendaraan)
    {
        DB::beginTransaction();
        $model = MasterKendaraan::whereUuid($masterKendaraan)->first();
        try {
            $data = [
                'status_kendaraan' => $request->status_kendaraan,
                'jenis_kendaraan' => strtoupper($request->jenis_kendaraan),
                'tanggal_beli_sewa_at' => $request->tanggal_beli_sewa_at,
                'current_km' => $request->current_km,
                'max_tangki' => $request->max_tangki,
                'nama' => $request->nama,
                'tanggal_jual_sewa_at' => $request->tanggal_jual_sewa_at,
                'status' => $request->status
            ];

            if (strtoupper($request->status_kendaraan) == 'SEWA') {
                $data['agen_sewa'] = strtoupper($request->agen_sewa);
            }

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
     * @param  \App\Models\MasterKendaraan  $masterKendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $masterKendaraan)
    {
        try {
            DB::beginTransaction();
            $model = MasterKendaraan::whereUuid($masterKendaraan)->first();
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

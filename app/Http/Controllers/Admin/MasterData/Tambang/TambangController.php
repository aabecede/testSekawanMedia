<?php

namespace App\Http\Controllers\Admin\MasterData\Tambang;

use App\Http\Controllers\Controller;
use App\Models\MasterTambang;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMasterTambangRequest;
use App\Http\Requests\UpdateMasterTambangRequest;
use App\Models\MasterRegion;

class TambangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $select = 'uuid,master_region_id,nama,alamat'; #untuk selectnya
    protected $base_url = 'admin/master-data/tambang'; #base url routenya
    public function index()
    {
        $base_url = $this->base_url;
        $data = (new TambangRead())->paginateMasterTambang(10, $this->select);
        return view('admin.master-data.master-tambang.index', compact(
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
        $base_url = $this->base_url;
        $region = MasterRegion::all();
        return view('admin.master-data.master-tambang.create', compact(
            'base_url',
            'region'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasterTambangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterTambangRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'master_region_id' => $request->master_region_id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
            ];
            MasterTambang::create($data);
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
     * @param  \App\Models\MasterTambang  $masterTambang
     * @return \Illuminate\Http\Response
     */
    public function show(MasterTambang $masterTambang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterTambang  $masterTambang
     * @return \Illuminate\Http\Response
     */
    public function edit(String $uuid)
    {
        $data = MasterTambang::whereUuid($uuid)->first();
        $base_url = $this->base_url;
        $region = MasterRegion::all();
        return view('admin.master-data.master-tambang.create', compact(
            'base_url',
            'data',
            'region'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterTambangRequest  $request
     * @param  \App\Models\MasterTambang  $masterTambang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterTambangRequest $request, String $uuid)
    {
        DB::beginTransaction();
        $model = MasterTambang::whereUuid($uuid)->first();
        try {
            $data = $request->all();

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
     * @param  \App\Models\MasterTambang  $masterTambang
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $uuid)
    {
        try {
            DB::beginTransaction();
            $model = MasterTambang::whereUuid($uuid)->first();
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

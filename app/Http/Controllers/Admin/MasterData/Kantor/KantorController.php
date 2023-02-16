<?php

namespace App\Http\Controllers\Admin\MasterData\Kantor;

use App\Http\Controllers\Controller;
use App\Models\MasterKantor;
use App\Http\Requests\StoreMasterKantorRequest;
use App\Http\Requests\UpdateMasterKantorRequest;
use App\Models\MasterRegion;
use Illuminate\Support\Facades\DB;

class KantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $select = 'uuid,region_id,tipe_kantor,nama,alamat';
    protected $base_url = 'admin/master-data/kantor';
    public function index()
    {
        $selected_data = $this->select;
        $data = (new KantorRead())->paginateMasterKantor($paginate = 10, $selected_data);
        return view('admin.master-data.master-kantor.index', compact(
            'selected_data',
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
        $region = MasterRegion::selectRaw('id,uuid,nama')->get();
        $tipe_kantor = MasterKantor::$tipeKantor;

        return view('admin.master-data.master-kantor.create', compact(
            'base_url',
            'region',
            'tipe_kantor'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasterRegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterKantorRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'region_id' => $request->region_id,
                'tipe_kantor' => $request->tipe_kantor,
            ];
            MasterKantor::create($data);
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
     * @param  \App\Models\MasterKantor  $masterKantor
     * @return \Illuminate\Http\Response
     */
    public function show(MasterKantor $masterKantor)
    {
        //        return view("admin.article.show", compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterKantor  $masterKantor
     * @return \Illuminate\Http\Response
     */
    public function edit(String $uuid)
    {
        $data = MasterKantor::whereUuid($uuid)->first();
        $base_url = $this->base_url;
        $region = MasterRegion::selectRaw('id,uuid,nama')->get();
        $tipe_kantor = MasterKantor::$tipeKantor;

        return view('admin.master-data.master-kantor.create', compact(
            'data',
            'base_url',
            'region',
            'tipe_kantor'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterKantorRequest  $request
     * @param  \App\Models\MasterKantor  $masterKantor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterKantorRequest $request, String $uuid)
    {
        DB::beginTransaction();
        $master_region = MasterKantor::whereUuid($uuid)->first();
        try {
            $data = [
                'nama' => $request->nama,
                'alamat' => $request->alamat,
            ];

            $master_region->update($data);
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
     * @param  \App\Models\MasterKantor  $masterKantor
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $uuid)
    {
        try {
            DB::beginTransaction();
            $master_region = MasterKantor::whereUuid($uuid)->first();
            if (empty($master_region)) {
                return $this->errorJson();
            }
            $master_region->delete();
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

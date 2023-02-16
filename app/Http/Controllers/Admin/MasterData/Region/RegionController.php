<?php

namespace App\Http\Controllers\Admin\MasterData\Region;

use App\Http\Controllers\Controller;
use App\Models\MasterRegion;
use App\Http\Requests\StoreMasterRegionRequest;
use App\Http\Requests\UpdateMasterRegionRequest;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $select = 'uuid,nama,alamat';
    protected $base_url = 'admin/master-data/region';
    public function index()
    {
        $selected_data = $this->select;
        $data = (new RegionRead())->paginateMasterRegion($paginate = 2, $selected_data);
        return view('admin.master-data.master-region.index',compact(
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
        return view('admin.master-data.master-region.create', compact(
            'base_url'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasterRegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterRegionRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'nama' => $request->nama,
                'alamat' => $request->alamat,
            ];
            MasterRegion::create($data);
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
     * @param  \App\Models\MasterRegion  $masterRegion
     * @return \Illuminate\Http\Response
     */
    public function show(MasterRegion $masterRegion)
    {
//        return view("admin.article.show", compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterRegion  $masterRegion
     * @return \Illuminate\Http\Response
     */
    public function edit(String $uuid)
    {
        $data = MasterRegion::whereUuid($uuid)->first();
        $base_url = $this->base_url;
        return view('admin.master-data.master-region.create', compact(
            'data',
            'base_url'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterRegionRequest  $request
     * @param  \App\Models\MasterRegion  $masterRegion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterRegionRequest $request, String $uuid)
    {
        DB::beginTransaction();
        $master_region = MasterRegion::whereUuid($uuid)->first();
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
     * @param  \App\Models\MasterRegion  $masterRegion
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $uuid)
    {
        try {
            DB::beginTransaction();
            $master_region = MasterRegion::whereUuid($uuid)->first();
            if(empty($master_region)){
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

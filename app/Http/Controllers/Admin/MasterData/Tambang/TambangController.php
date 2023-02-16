<?php

namespace App\Http\Controllers\Admin\MasterData\Tambang;

use App\Http\Controllers\Controller;
use App\Models\MasterTambang;
use App\Http\Requests\StoreMasterTambangRequest;
use App\Http\Requests\UpdateMasterTambangRequest;

class TambangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasterTambangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterTambangRequest $request)
    {
        //
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
    public function edit(MasterTambang $masterTambang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterTambangRequest  $request
     * @param  \App\Models\MasterTambang  $masterTambang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterTambangRequest $request, MasterTambang $masterTambang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterTambang  $masterTambang
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterTambang $masterTambang)
    {
        //
    }
}

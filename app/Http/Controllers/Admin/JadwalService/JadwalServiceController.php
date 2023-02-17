<?php

namespace App\Http\Controllers\Admin\JadwalService;

use App\Http\Controllers\Controller;
use App\Models\JadwalService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreJadwalServiceRequest;
use App\Http\Requests\UpdateJadwalServiceRequest;
use App\Models\MasterKendaraan;

class JadwalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // protected $select = '*'; #untuk selectnya
    protected $base_url = 'admin/jadwal-service'; #base url routenya
    public function index()
    {
        $base_url = $this->base_url;
        $data = JadwalService::with([
            'master_kendaraan'
        ])
            ->paginate(10);
        return view('admin.jadwal-service.index', compact(
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
        $kendaraan = MasterKendaraan::all();
        return view('admin.jadwal-service.create', compact(
            'base_url',
            'kendaraan'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJadwalServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJadwalServiceRequest $request)
    {
        $this->middleware('isAdmin');
        DB::beginTransaction();
        try {

            $bukti_struk = null;
            if ($request->file('bukti_struk')) {

                $slug      = slugCustom($request->nama);
                $file      = $request->file() ?? [];
                $path      = 'uploads/jadwal-service/'.date('Y-m-d').'/';
                $config_file = [
                    'patern_filename'   => $slug,
                    'is_convert'        => true,
                    'file'              => $file,
                    'path'              => $path,
                    'convert_extention' => 'jpeg'
                ];

                $bukti_struk = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['bukti_struk'];
            }

            $data = [
                'master_kendaraan_id' => $request->master_kendaraan_id,
                'tanggal_service_at' => $request->tanggal_service_at,
                'keterangan' => $request->keterangan,
                'bukti_struk' => $bukti_struk
            ];
            // dd($data);
            JadwalService::create($data);
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
     * @param  \App\Models\JadwalService  $jadwalService
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalService $jadwalService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalService  $jadwalService
     * @return \Illuminate\Http\Response
     */
    public function edit(String $jadwalService)
    {
        $this->middleware('isAdmin');
        $data = JadwalService::whereUuid($jadwalService)->first();
        $base_url = $this->base_url;
        $kendaraan = MasterKendaraan::all();
        return view('admin.jadwal-service.create', compact(
            'base_url',
            'data',
            'kendaraan'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJadwalServiceRequest  $request
     * @param  \App\Models\JadwalService  $jadwalService
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJadwalServiceRequest $request, String $jadwalService)
    {
        $this->middleware('isAdmin');
        DB::beginTransaction();
        $model = JadwalService::whereUuid($jadwalService)->first();
        try {
            $data = [
                'master_kendaraan_id' => $request->master_kendaraan_id,
                'tanggal_service_at' => $request->tanggal_service_at,
                'keterangan' => $request->keterangan,
            ];

            if ($request->file('bukti_struk')) {
                try {
                    if (!empty($model->bukti_struk)) {
                        unlink($model->bukti_struk);
                    }
                } catch (\Throwable $th) {
                    #just continue
                }
                $slug      = slugCustom($request->nama);
                $file      = $request->file() ?? [];
                $path      = 'uploads/jadwal-service/' . date('Y-m-d') . '/';
                $config_file = [
                    'patern_filename'   => $slug,
                    'is_convert'        => true,
                    'file'              => $file,
                    'path'              => $path,
                    'convert_extention' => 'jpeg'
                ];

                $bukti_struk = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['bukti_struk'];
                $data['bukti_struk'] = $bukti_struk;
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
     * @param  \App\Models\JadwalService  $jadwalService
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $jadwalService)
    {
        $this->middleware('isAdmin');
        try {
            DB::beginTransaction();
            $model = JadwalService::whereUuid($jadwalService)->first();
            if (empty($model)) {
                return $this->errorJson();
            }
            try {
                if (!empty($model->bukti_struk)) {
                    unlink($model->bukti_struk);
                }
            } catch (\Throwable $th) {
                #just continue
            }
            $model->update([
                'deleted_by' => auth()->id(),
                'deleted_at' => now(),
            ]);

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

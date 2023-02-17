<?php

namespace App\Http\Controllers\Admin\KonsumsiBbm;

use App\Models\KonsumsiBBM;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreKonsumsiBBMRequest;
use App\Http\Requests\UpdateKonsumsiBBMRequest;
use App\Models\MasterKendaraan;

class KonsumsiBbmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $select = '*'; #untuk selectnya
    protected $base_url = 'admin/konsumsi-bbm'; #base url routenya
    public function index()
    {
        $base_url = $this->base_url;
        $data = KonsumsiBBM::with([
            'master_kendaraan'
        ])->paginate(10);
        return view('admin.konsumsi-bbm.index', compact(
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
        $kendaraan = MasterKendaraan::All();
        return view('admin.konsumsi-bbm.create', compact(
            'base_url',
            'kendaraan'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKonsumsiBBMRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKonsumsiBBMRequest $request)
    {

        DB::beginTransaction();
        try {

            $bukti_struk = null;
            if ($request->file('bukti_struk')) {

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
            }
            $data = [
                'master_kendaraan_id' => $request->master_kendaraan_id,
                'tanggal_isi_at' => $request->tanggal_isi_at,
                'total_liter' => $request->total_liter,
                'total_harga' => $request->total_harga,
                'bukti_struk' => $bukti_struk,
            ];
            KonsumsiBBM::create($data);
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
     * @param  \App\Models\KonsumsiBBM  $konsumsiBBM
     * @return \Illuminate\Http\Response
     */
    public function show(KonsumsiBBM $konsumsiBBM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KonsumsiBBM  $konsumsiBBM
     * @return \Illuminate\Http\Response
     */
    public function edit(String $konsumsiBBM)
    {
        $data = KonsumsiBBM::whereUuid($konsumsiBBM)->first();
        $base_url = $this->base_url;
        $kendaraan = MasterKendaraan::All();
        return view('admin.konsumsi-bbm.create', compact(
            'base_url',
            'data',
            'kendaraan'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKonsumsiBBMRequest  $request
     * @param  \App\Models\KonsumsiBBM  $konsumsiBBM
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKonsumsiBBMRequest $request, String $konsumsiBBM)
    {
        DB::beginTransaction();
        $model = KonsumsiBBM::whereUuid($konsumsiBBM)->first();
        try {
            $data = [
                'master_kendaraan_id' => $request->master_kendaraan_id,
                'tanggal_isi_at' => $request->tanggal_isi_at,
                'total_liter' => $request->total_liter,
                'total_harga' => $request->total_harga,
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
     * @param  \App\Models\KonsumsiBBM  $konsumsiBBM
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $konsumsiBBM)
    {
        try {
            DB::beginTransaction();
            $model = KonsumsiBBM::whereUuid($konsumsiBBM)->first();
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

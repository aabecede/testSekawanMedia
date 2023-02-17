<?php

namespace App\Http\Controllers\Admin\MasterData\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaserData\PemesananDriverAvailAbleRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\MasterRegion;
use App\Models\Pemesanan;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $select = '*'; #untuk selectnya
    protected $base_url = 'admin/master-data/pegawai'; #base url routenya
    public function index()
    {
        $base_url = $this->base_url;
        $data = User::paginate(10);
        return view('admin.master-data.master-pegawai.index', compact(
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
        $jabatan = User::$enum_jabatan;
        $role = User::$enum_role;
        $status = User::$enum_status;
        return view('admin.master-data.master-pegawai.create', compact(
            'base_url',
            'region',
            'jabatan',
            'role',
            'status'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        try {

            $jumlah_user_region = User::where('master_region_id', $request->master_region_id)->count('id') + 1;
            $master_region_id = $request->master_region_id ?? null;
            if(empty($master_region_id)){
                $nip = "SA-$jumlah_user_region";
            }
            else{
                $nip = "$master_region_id-$jumlah_user_region";
            }

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('123456789'),
                'master_region_id' => $master_region_id,
                'nip' => $nip,
                'jabatan' => $request->jabatan,
                'role' => $request->role,
                'status' => $request->status,
            ];
            User::create($data);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(String $user)
    {
        $data = User::whereUuid($user)->first();
        $base_url = $this->base_url;
        $region = MasterRegion::all();
        $jabatan = User::$enum_jabatan;
        $role = User::$enum_role;
        $status = User::$enum_status;
        return view('admin.master-data.master-pegawai.create', compact(
            'base_url',
            'data',
            'region',
            'jabatan',
            'role',
            'status'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, String $user)
    {
        DB::beginTransaction();
        $model = User::whereUuid($user)->first();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'master_region_id' => $request->master_region_id,
                'jabatan' => $request->jabatan,
                'role' => $request->role,
                'status' => $request->status,
            ];

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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $user)
    {
        try {
            DB::beginTransaction();
            $model = User::whereUuid($user)->first();
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

    public function pemesananDriverAvailable(PemesananDriverAvailAbleRequest $request){
        try {

            $request->merge([
                'tanggal_berangkat' => Carbon::parse($request->tanggal_berangkat),
                'tanggal_pulang' => Carbon::parse($request->tanggal_pulang),
            ]);
            $base_pemesanan = Pemesanan::selectRaw('id,driver,status,tanggal_keberangkatan_at,tanggal_pulang_at')
                ->whereIn('status', [1, 2, 3]);

            $arr_driver = with(clone $base_pemesanan)
                ->where(function ($q) {
                    $q->where('tanggal_keberangkatan_at', '>=', request()->tanggal_berangkat)
                        ->where('tanggal_keberangkatan_at', '<=', request()->tanggal_pulang);
                })
                ->get()
                ->pluck('driver')
                ->toArray();

            $driver = User::whereNotIn('id', $arr_driver)
                ->selectRaw('id,name,nip,jabatan,role')
                ->where('jabatan', 'DRIVER')
                ->where('status', 'aktif')
                ->get()
                ->each
                ->append('attr_user_jabatan');

            $result = [
                'data' => $driver
            ];

            return $this->successJson($result);
        } catch (\Throwable $th) {
            return $this->exceptionJson($th);
        }
    }
}

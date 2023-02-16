<?php

namespace App\Http\Controllers\Admin\MasterData\Kendaraan;

use App\Models\MasterKendaraan;

class KendaraanRead
{
    public function paginateMasterKendaraan(Int $paginate = 1, $select = 'id'){
        $result = MasterKendaraan::selectRaw($select)->paginate($paginate);
        return $result;
    }
}

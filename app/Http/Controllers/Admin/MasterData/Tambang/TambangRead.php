<?php

namespace App\Http\Controllers\Admin\MasterData\Tambang;

use App\Models\MasterTambang;

class TambangRead
{
    public function paginateMasterTambang(Int $paginate = 1, $select = 'id')
    {
        $result = MasterTambang::with([
            'master_region:id,nama'
        ])
            ->selectRaw($select)->paginate($paginate);
        return $result;
    }
}

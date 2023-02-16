<?php

namespace App\Http\Controllers\Admin\MasterData\Kantor;

use App\Models\MasterKantor;

class KantorRead
{
    public function paginateMasterKantor(Int $paginate = 1, $select = 'id')
    {
        $result = MasterKantor::with([
            'master_region:id,nama'
        ])
            ->selectRaw($select)->paginate($paginate);
        return $result;
    }
}

<?php

namespace App\Http\Controllers\Admin\MasterData\Region;

use App\Models\MasterRegion;
use Illuminate\Support\Facades\Cache;

class RegionRead
{
    public function paginateMasterRegion(Int $paginate = 1, $select = 'id'){
        $result = MasterRegion::selectRaw($select)->paginate($paginate);
        return $result;
    }
}

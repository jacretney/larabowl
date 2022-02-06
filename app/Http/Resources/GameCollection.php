<?php

namespace App\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->toArray();
    }
}

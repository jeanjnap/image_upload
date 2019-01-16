<?php

namespace App\Http\Resources\Resources;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $photo_search = DB::table('photos')->select(['*'])->where('id', $this->id)->first();

        //return $photo_search;

        return [
            'id' => $this->id,
            'file' => asset('storage/pictures/' . $photo_search->file_name),
            'created_at' => $photo_search->created_at
        ];
    }
}

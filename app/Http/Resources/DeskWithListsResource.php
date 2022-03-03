<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeskWithListsResource extends DeskResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd(DeskListResource::collection($this->lists)->collection->sortByDesc('created_at'));
        $parentArray = parent::toArray($request);
        $parentArray['lists'] = DeskListResource::collection($this->lists);
        return $parentArray;
    }
}

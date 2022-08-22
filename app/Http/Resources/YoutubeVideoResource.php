<?php

namespace App\Http\Resources;

use App\Helpers\YoutubeVideoHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class YoutubeVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'sid' => $this->sid,
            'title' => $this->title,
            'thumbnail' => $this->thumbnail,
            'date_raw' => $this->date,
            'date' => YoutubeVideoHelper::getDateFormat($this->date)
        ];
    }
}

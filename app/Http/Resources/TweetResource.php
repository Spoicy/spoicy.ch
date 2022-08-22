<?php

namespace App\Http\Resources;

use App\Helpers\TweetHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
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
            'text' => $this->text,
            'link' => $this->link,
            'media' => $this->media,
            'date_raw' => $this->date,
            'date' => TweetHelper::getDateFormat($this->date)
        ];
    }
}

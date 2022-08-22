<?php

namespace App\Http\Resources;

use App\Helpers\GithubEventHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class GithubEventResource extends JsonResource
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
            'link' => $this->link,
            'author' => $this->author,
            'type' => $this->type,
            'entrydata' => json_decode($this->entrydata),
            'date_raw' => $this->date,
            'date' => GithubEventHelper::getDateFormat($this->date)
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Helpers\SpeedrunHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeedrunResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'sid' => $this->sid,
            'game' => $this->game,
            'game_link' => $this->game_link,
            'category' => $this->category,
            'category_link' => $this->category_link,
            'date_raw' => $this->date,
            'time_raw' => $this->time,
            'date' => SpeedrunHelper::getDateFormat($this->date),
            'time' => SpeedrunHelper::getTimeFormat($this->time),
            'image' => $this->image,
            'type' => $this->type,
        ];
    }
}

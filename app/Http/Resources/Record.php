<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Record extends JsonResource
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
            'data' => [
                'type' => 'records',
                'record_id' => $this->id,
                'attributes' => [
                    'score' => $this->score,
                    'users' => new UserResource($this->user),
                ]
            ],
            'links' => [
                'self' => url('/getRecord/'.$this->id),
            ]
        ];
    }
}

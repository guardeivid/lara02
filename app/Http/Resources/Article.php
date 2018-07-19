<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        
        //para no mostrar todos los datos en la respuesta y solo limitar a algunos
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body
        ];
    }

    //para agregar mas datos en la respuesta
    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://traversymedia.com')
        ];
    }
}

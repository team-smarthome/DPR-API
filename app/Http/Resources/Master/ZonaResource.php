<?php
namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZonaResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
        'id' => $this->id,
        'parent_id' => $this->parent_id,
        'nama_zona' => $this->nama_zona,
        'jenis_zona' => $this->jenis_zona,
        'lokasi_id' => $this->lokasi_id,
        'panjang' => $this->panjang,
        'lebar' => $this->lebar,
        'posisi_X' => $this->posisi_X,
        'posisi_Y' => $this->posisi_Y,
        'subZona' => $this->whenLoaded('recursiveParents', fn () => new ZonaResource($this->recursiveParents)),
    ];
  }
}

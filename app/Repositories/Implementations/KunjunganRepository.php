<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\KunjunganResource;
use App\Models\Kunjungan;
use App\Repositories\Interfaces\KunjunganRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KunjunganRepository implements KunjunganRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
      DB::beginTransaction();

      try {
          $kunjunganData = $data;
          unset($kunjunganData['pengunjung_id']);

          $existingKunjungan = Kunjungan::where('nama_kunjungan', $kunjunganData['nama_kunjungan'])->first();

          if ($existingKunjungan) {
              DB::rollBack();
              return $this->alreadyExist('Kunjungan Already Exist');
          }

          $kunjungan = Kunjungan::create($kunjunganData);

          if (isset($data['pengunjung_id']) && is_array($data['pengunjung_id'])) {
              $pivotData = [];

              foreach ($data['pengunjung_id'] as $pengunjungId) {
                  $pivotData[] = [
                      'id' => Str::uuid(),
                      'kunjungan_id' => $kunjungan->id,
                      'pengunjung_id' => $pengunjungId
                  ];
              }

              DB::table('pivot_kunjungan')->insert($pivotData);
          }

          DB::commit();

          return $this->created(new KunjunganResource($kunjungan));
      } catch (\Exception $e) {
          DB::rollBack();
          throw new ErrorException("Gagal membuat kunjungan: " . $e->getMessage());
      }
  }

   public function get(Request $request)
   {
        try {
            $kunjungan = Kunjungan::with('pengunjung')->get();
            return $this->success(KunjunganResource::collection($kunjungan));
        } catch (\Exception $e) {
            throw new ErrorException("Gagal mengambil data kunjungan: " . $e->getMessage());
        }
    }


  public function getById(string $id): ?Kunjungan
  {
    return Kunjungan::find($id);
  }

  public function update(string $id, array $data)
  {
      if (!Str::isUuid($id)) {
          return $this->invalidUUid();
      }

      $model = Kunjungan::find($id);
      if (!$model) {
          return $this->notFound();
      }

      DB::beginTransaction();

      try {
          $kunjunganData = $data;
          unset($kunjunganData['pengunjung_id']);
          
          $model->update($kunjunganData);
          DB::table('pivot_kunjungan')->where('kunjungan_id', $model->id)->delete();

          if (isset($data['pengunjung_id']) && is_array($data['pengunjung_id'])) {
              $pivotData = [];
              foreach ($data['pengunjung_id'] as $pengunjungId) {
                  $pivotData[] = [
                      'id' => Str::uuid(),
                      'kunjungan_id' => $model->id,
                      'pengunjung_id' => $pengunjungId
                  ];
              }

              DB::table('pivot_kunjungan')->insert($pivotData);
          }

          DB::commit();

          return $this->updated();
      } catch (\Exception $e) {
          DB::rollBack();
          throw new ErrorException("Gagal memperbarui kunjungan: " . $e->getMessage());
      }
  }


  public function delete(string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Kunjungan::find($id);
    if (!$model) {
      return $this->notFound();
    }

    DB::beginTransaction();

    try {
      DB::table('pivot_kunjungan')->where('kunjungan_id', $model->id)->update(['deleted_at' => now()]);
      $model->delete();
      DB::commit();

      return $this->deleted();
    } catch (\Exception $e) {
      DB::rollBack();
      throw new ErrorException("Gagal menghapus kunjungan: " . $e->getMessage());
    }
  }
}

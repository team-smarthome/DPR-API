<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\PermohonanAbsensiResource;
use App\Models\PermohonanAbsensi;
use App\Repositories\Interfaces\PermohonanAbsensiRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PermohonanAbsensiRepository implements PermohonanAbsensiRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    try {
      $waktuMulai = Carbon::parse($data['waktu_mulai']);
      $waktuSelesai = Carbon::parse($data['waktu_selesai']);
      $calculatedDays = ceil($waktuMulai->diffInHours($waktuSelesai) / 24);

      if ($data['jumlah_hari'] != $calculatedDays) {
        return $this->wrapResponse(Response::HTTP_BAD_REQUEST, "Jumlah hari tidak sesuai dengan selisih waktu mulai dan waktu selesai.");
      }

      if (isset($data['image_lampiran']) && $this->isBase64Image($data['image_lampiran'])) {
        $data['image_lampiran'] = $this->saveBase64Image($data['image_lampiran'], 'images/permohonan_absensi');
      }
      return $this->created(PermohonanAbsensi::create($data));
    } catch (\Exception $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  public function get(Request $request)
  {
    $collection = PermohonanAbsensi::with(['pegawai'])->latest();
    $pegawaiId = $request->query("pegawai_id");

    if ($pegawaiId) {
      $collection->where('pegawai_id', $pegawaiId);
    }

    $isNotPaginate = $request->query("not-paginate");

    if ($isNotPaginate) {
      $collection = $collection->get();
      $result = PermohonanAbsensiResource::collection($collection)->response()->getData(true);
      return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
    } else {
      return $this->paginate2($collection, 'Successfully get Data', PermohonanAbsensiResource::class);
    }
  }

  public function getById(string $id)
  {
    return PermohonanAbsensi::find($id);
  }

  public function update(string $id, array $data)
  {
    try {

      $waktuMulai = Carbon::parse($data['waktu_mulai']);
      $waktuSelesai = Carbon::parse($data['waktu_selesai']);
      $calculatedDays = $waktuMulai->diffInDays($waktuSelesai) + 1;

      $model = PermohonanAbsensi::find($id);
      if (!$model) {
        return $this->notFound();
      }



      $waktuMulai = Carbon::parse($data['waktu_mulai']);
      $waktuSelesai = Carbon::parse($data['waktu_selesai']);
      $calculatedDays = ceil($waktuMulai->diffInHours($waktuSelesai) / 24);


      if ($data['jumlah_hari'] != $calculatedDays) {
        return $this->wrapResponse(Response::HTTP_BAD_REQUEST, "Jumlah hari tidak sesuai dengan selisih waktu mulai dan waktu selesai.");
      }

      if (isset($data['image_lampiran']) && $this->isBase64Image($data['image_lampiran'])) {
        $data['image_lampiran'] = $this->saveBase64Image($data['image_lampiran'], 'images/permohonan_absensi');
      }
      $model->update($data);
      return $this->updated();
    } catch (\Exception $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  public function delete(string $id)
  {
    try {
      $model = PermohonanAbsensi::find($id);
      if (!$model) {
        return $this->notFound();
      }
      $model->delete();
      return $this->deleted();
    } catch (ValidationException $e) {
      throw new ValidationException($e->getMessage());
    } catch (\Throwable $th) {
      throw new ErrorException('Terjadi kesalahan: ' . $th->getMessage());
    }
  }
}

<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\WfhPegawaiResource;
use App\Models\WfhPegawai;
use App\Repositories\Interfaces\WfhPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class WfhPegawaiRepository implements WfhPegawaiRepositoryInterface
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

      if (isset($data['image_url']) && $this->isBase64Image($data['image_url'])) {
        $data['image_url'] = $this->saveBase64Image($data['image_url'], 'images/wfh_pegawai');
      }
      return $this->created(WfhPegawai::create($data));
    } catch (\Exception $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  public function get(Request $request)
  {
    try {
      $collection = WfhPegawai::with(['pegawai'])->latest();
      $pegawaiId = $request->query("pegawai_id");

      if ($pegawaiId) {
        $collection->where('pegawai_id', $pegawaiId);
      }

      $isNotPaginate = $request->query("not-paginate");

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = WfhPegawaiResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', WfhPegawaiResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?WfhPegawai
  {
    return WfhPegawai::find($id);
  }

  public function update(string $id, array $data)
  {
    try {

      $waktuMulai = Carbon::parse($data['waktu_mulai']);
      $waktuSelesai = Carbon::parse($data['waktu_selesai']);
      $calculatedDays = $waktuMulai->diffInDays($waktuSelesai) + 1;

      $model = WfhPegawai::find($id);
      if (!$model) {
        return $this->notFound();
      }

      $waktuMulai = Carbon::parse($data['waktu_mulai']);
      $waktuSelesai = Carbon::parse($data['waktu_selesai']);
      $calculatedDays = ceil($waktuMulai->diffInHours($waktuSelesai) / 24);


      if ($data['jumlah_hari'] != $calculatedDays) {
        return $this->wrapResponse(Response::HTTP_BAD_REQUEST, "Jumlah hari tidak sesuai dengan selisih waktu mulai dan waktu selesai.");
      }

      if (isset($data['image_url']) && $this->isBase64Image($data['image_url'])) {
        $data['image_url'] = $this->saveBase64Image($data['image_url'], 'images/wfh_pegawai');
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
      $model = WfhPegawai::find($id);
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

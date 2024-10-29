<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\AbsensiPegawaiResource;
use App\Models\AbsensiPegawai;
use App\Repositories\Interfaces\AbsensiPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class AbsensiPegawaiRepository implements AbsensiPegawaiRepositoryInterface
{

  use ResponseTrait;


  public function create(array $data)
  {
    try {
      $waktuMulai = strtotime($data['waktu_mulai']);
      $batasTepatWaktu = strtotime(date('Y-m-d 09:00:00', $waktuMulai));

      if ($waktuMulai > $batasTepatWaktu) {
        $data['keterangan'] = 'telat';
        $keterlambatanDetik = $waktuMulai - $batasTepatWaktu;

        $keterlambatanMenit = floor($keterlambatanDetik / 60);
        $keterlambatanJam = floor($keterlambatanMenit / 60);
        $sisaMenit = $keterlambatanMenit % 60;

        if ($keterlambatanJam > 0) {
          $data['keterangan'] .= " $keterlambatanJam jam $sisaMenit menit";
        } else {
          $data['keterangan'] .= " $keterlambatanMenit menit";
        }
      } else {
        $data['keterangan'] = 'tepat waktu';
      }

      if (isset($data['image_url']) && $this->isBase64Image($data['image_url'])) {
        $data['image_url'] = $this->saveBase64Image($data['image_url'], 'images/absensi_pegawai');
      }

      return $this->created(AbsensiPegawai::create($data));
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }


  public function get(Request $request)
  {
    try {
      $collection = AbsensiPegawai::with(['pegawai'])->latest();

      $pegawaiId = $request->query("pegawai_id");

      if ($pegawaiId) {
        $collection->where('pegawai_id', $pegawaiId);
      }

      $isNotPaginate = $request->query("not-paginate");

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = AbsensiPegawaiResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', AbsensiPegawaiResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id)
  {
    return AbsensiPegawai::find($id);
  }

  public function update(string $id, array $data)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = AbsensiPegawai::find($id);
    if (!$model) {
      return $this->notFound();
    }

    $waktuMulai = strtotime($data['waktu_mulai']);
    $batasTepatWaktu = strtotime(date('Y-m-d 09:00:00', $waktuMulai));

    if ($waktuMulai > $batasTepatWaktu) {
      $data['keterangan'] = 'telat';
      $keterlambatanDetik = $waktuMulai - $batasTepatWaktu;

      $keterlambatanMenit = floor($keterlambatanDetik / 60);
      $keterlambatanJam = floor($keterlambatanMenit / 60);
      $sisaMenit = $keterlambatanMenit % 60;

      if ($keterlambatanJam > 0) {
        $data['keterangan'] .= " $keterlambatanJam jam $sisaMenit menit";
      } else {
        $data['keterangan'] .= " $keterlambatanMenit menit";
      }
    } else {
      $data['keterangan'] = 'tepat waktu';
    }

    if (isset($data['image_url']) && $this->isBase64Image($data['image_url'])) {
      $data['image_url'] = $this->saveBase64Image($data['image_url'], 'images/absensi_pegawai');
    } else {

      unset($data['image_url']);
    }

    $model->update($data);
    return $this->updated();
  }


  public function delete(string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = AbsensiPegawai::find($id);
    if (!$model) {
      return $this->notFound();
    }

    $model->delete();
    return $this->deleted();
  }
}

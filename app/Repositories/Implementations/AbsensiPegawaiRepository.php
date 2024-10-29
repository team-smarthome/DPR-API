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
      $tepatWaktu = Carbon::createFromTime(9, 0, 0);  // Waktu referensi untuk tepat waktu
      $waktuMulai = Carbon::parse($data['waktu_mulai']); // Parse waktu mulai dari input

      if ($waktuMulai->lessThanOrEqualTo($tepatWaktu)) {
        $data['keterangan'] = 'Tepat Waktu';
      } else {
        $diffInMinutes = $waktuMulai->diffInMinutes($tepatWaktu);
        $hours = floor($diffInMinutes / 60);
        $minutes = $diffInMinutes % 60;

        if ($hours > 0) {
          $data['keterangan'] = "Terlambat {$hours} jam {$minutes} menit";
        } else {
          $data['keterangan'] = "Terlambat {$minutes} menit";
        }
      }


      if (isset($data['image_url']) && $this->isBase64Image($data['image_url'])) {
        $data['image_url'] = $this->saveBase64Image($data['image_url'], 'images/absensi_pegawai');
      }
      return $this->created(AbsensiPegawai::create($data));
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  // public function get(Request $request)
  // {
  //   try {
  //     $collection = AbsensiPegawai::with(['pegawai'])->latest();
  //     $isNotPaginate = $request->query("not-paginate");


  //     if ($isNotPaginate) {
  //       $collection = $collection->get();
  //       $result = AbsensiPegawaiResource::collection($collection)->response()->getData(true);
  //       return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
  //     } else {
  //       return $this->paginate2($collection, 'Successfully get Data', AbsensiPegawaiResource::class);
  //     }
  //   } catch (ValidationException $e) {
  //     return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
  //   } catch (ErrorException $e) {
  //     return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
  //   } catch (\Throwable $th) {
  //     return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
  //   }
  // }

  public function get(Request $request)
  {
    try {
      // Mengambil query builder untuk AbsensiPegawai dengan relasi pegawai
      $collection = AbsensiPegawai::with(['pegawai'])->latest();

      // Cek apakah terdapat parameter 'pegawai_id' di request
      $pegawaiId = $request->query("pegawai_id");

      if ($pegawaiId) {
        $collection->where('pegawai_id', $pegawaiId);
      }

      // Periksa jika ada parameter 'not-paginate'
      $isNotPaginate = $request->query("not-paginate");

      if ($isNotPaginate) {
        // Jika tidak menggunakan pagination, ambil semua data
        $collection = $collection->get();
        $result = AbsensiPegawaiResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        // Jika menggunakan pagination, gunakan metode paginate2
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

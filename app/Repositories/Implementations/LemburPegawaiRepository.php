<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\LemburPegawaiResource;
use App\Models\LemburPegawai;
use App\Repositories\Interfaces\LemburPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LemburPegawaiRepository implements LemburPegawaiRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    try {
      $waktuMasuk = Carbon::parse($data['waktu_masuk']);
      $waktuKeluar = Carbon::parse($data['waktu_keluar']);

      // Hitung durasi bekerja dalam jam
      $hours = $waktuKeluar->diffInHours($waktuMasuk);
      $minutes = $waktuKeluar->diffInMinutes($waktuMasuk) % 60;

      $data['keterangan'] = $hours > 0 ? 'Lembur' . ' ' . $hours . ' jam' . ' ' . $minutes . ' menit' : 'Lembur' . ' ' . $minutes . ' menit';


      if (isset($data['image_url']) && $this->isBase64Image($data['image_url'])) {
        $data['image_url'] = $this->saveBase64Image($data['image_url'], 'images/lembur_pegawai');
      }

      if ($data['waktu_keluar'] <= $data['waktu_masuk']) {
        return $this->wrapResponse(Response::HTTP_BAD_REQUEST, 'Waktu keluar tidak boleh lebih kecil atau sama dengan waktu masuk');
      }
      return $this->created(LemburPegawai::create($data));
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  public function get(Request $request)
  {
    try {
      $collection = LemburPegawai::with(['pegawai'])->latest();

      $pegawaiId = $request->query("pegawai_id");

      if ($pegawaiId) {
        $collection->where('pegawai_id', $pegawaiId);
      }

      $isNotPaginate = $request->query("not-paginate");

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = LemburPegawaiResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', LemburPegawaiResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?LemburPegawai
  {
    return LemburPegawai::find($id);
  }

  public function update(string $id, array $data)
  {
    try {
      $model = LemburPegawai::find($id);
      if (!$model) {
        return $this->notFound();
      }
      $waktuMasuk = Carbon::parse($data['waktu_masuk']);
      $waktuKeluar = Carbon::parse($data['waktu_keluar']);

      if ($waktuKeluar <= $waktuMasuk) {
        return $this->wrapResponse(Response::HTTP_BAD_REQUEST, 'Waktu keluar tidak boleh lebih kecil atau sama dengan waktu masuk');
      }

      $hours = $waktuKeluar->diffInHours($waktuMasuk);
      $minutes = $waktuKeluar->diffInMinutes($waktuMasuk) % 60;

      $data['keterangan'] = $hours > 0 ? 'Lembur ' . $hours . ' jam ' . $minutes . ' menit' : 'Lembur ' . $minutes . ' menit';

      if (isset($data['image_url']) && $this->isBase64Image($data['image_url'])) {
        $data['image_url'] = $this->saveBase64Image($data['image_url'], 'images/lembur_pegawai');
      }

      $model->update($data);
      return $this->updated();
    } catch (ValidationException $e) {
      throw new ValidationException($e->getMessage());
    } catch (\Throwable $th) {
      throw new ErrorException('Terjadi kesalahan: ' . $th->getMessage());
    }
  }


  public function delete(string $id)
  {
    try {
      $model = LemburPegawai::find($id);
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

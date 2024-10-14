<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\KunjunganResource;
use App\Models\Kunjungan;
use App\Repositories\Interfaces\KunjunganRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KunjunganRepository implements KunjunganRepositoryInterface
{
  use ResponseTrait;

  public function create(array $data, Request $request)
  {
    DB::beginTransaction();

    try {
      $kunjunganData = $data;
      unset($kunjunganData['pengunjung_id']);
      $kunjunganData['status'] = 'pending';


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

      return $this->created();
    } catch (\Exception $e) {
      DB::rollBack();
      throw new ErrorException("Gagal membuat kunjungan: " . $e->getMessage());
    }
  }




  public function get(Request $request)
  {
    try {
      $isPegawai = $request->get('is_pegawai');
      $pegawaiId = $request->get('pegawai_id');
      $pengunjungId = $request->get('pengunjung_id');
      $isApproved = $request->get('is_approved');
      $nama_kunjungan = $request->get('nama_kunjungan');
      $waktuMulai = $request->get('waktu_mulai');
      $waktuBerakhir = $request->get('waktu_berakhir');

      $query = Kunjungan::with(['pengunjung', 'pegawai']);

      if ($isPegawai == 1 && $pegawaiId) {
        $query->where('pegawai_tujuan_id', $pegawaiId);
      } elseif ($isPegawai == 0 && $pengunjungId) {
        $query->whereHas('pengunjung', function ($q) use ($pengunjungId) {
          $q->where('pengunjung_id', $pengunjungId);
        });
      }

      if (isset($nama_kunjungan)) {
        $query->where('nama_kunjungan', 'ilike', '%' . $nama_kunjungan . '%');
      }
      if (!is_null($isApproved)) {
        $query->where('is_approved', $isApproved);
      }

      if (!is_null($waktuMulai) && !is_null($waktuBerakhir)) {
        $query->whereBetween('waktu_mulai', [$waktuMulai, $waktuBerakhir]);
      } elseif (!is_null($waktuMulai)) {
        $query->where('waktu_mulai', '>=', $waktuMulai);
      } elseif (!is_null($waktuBerakhir)) {
        $query->where('waktu_berakhir', '<=', $waktuBerakhir);
      }
      $kunjungan = $query->get();

      return response()->json([
        'status' => 200,
        'message' => 'Get Data Successfully',
        'records' => KunjunganResource::collection($kunjungan),
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 500,
        'message' => "Gagal mengambil data kunjungan: " . $e->getMessage(),
      ], 500);
    }
  }


  public function getById(string $id): ?Kunjungan
  {
    return Kunjungan::find($id);
  }



  public function update(string $id, array $data, Request $request)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Kunjungan::find($id);
    if (!$model) {
      return $this->notFound();
    }
    if (isset($data['is_approved'])) {
      if ($data['is_approved'] == 2 && $model->is_approved == 1 && !is_null($model->approved_date)) {
        return $this->wrapResponse(422, 'Tidak bisa mengubah status ke tolak setelah disetujui');
      } elseif ($data['is_approved'] == 1 && $model->is_approved == 2 && !is_null($model->reject_date)) {
        return $this->wrapResponse(422, 'Tidak bisa mengubah status ke setuju setelah ditolak');
      }
    }

    DB::beginTransaction();

    try {
      $kunjunganData = $data;
      unset($kunjunganData['pengunjung_id']);


      if (isset($data['waktu_mulai'])) {
        $kunjunganData['waktu_mulai'] = $data['waktu_mulai'];
      }
      if (isset($data['waktu_berakhir'])) {
        $kunjunganData['waktu_berakhir'] = $data['waktu_berakhir'];
      }

      if (isset($data['is_approved'])) {
        if ($data['is_approved'] == 1) {
          $kunjunganData['approved_date'] = Carbon::now();
          $kunjunganData['is_approved'] = 1;
          $kunjunganData['status'] = 'approved';
        } elseif ($data['is_approved'] == 2) {
          $kunjunganData['reject_date'] = Carbon::now();
          $kunjunganData['is_approved'] = 2;
          $kunjunganData['status'] = 'rejected';
        }
      }

      $kunjunganData['approved_by_id'] = $request->user_id;

      $model->update($kunjunganData);

      if (isset($data['pengunjung_id']) && is_array($data['pengunjung_id'])) {
        DB::table('pivot_kunjungan')->where('kunjungan_id', $model->id)->delete();
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
      return $this->wrapResponse(200, 'Successfully Updated Data');
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


      return $this->deleted($statusMessage);
    } catch (\Exception $e) {
      DB::rollBack();
      throw new ErrorException("Gagal menghapus kunjungan: " . $e->getMessage());
    }
  }
}

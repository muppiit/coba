<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\SuratModel;
use App\Models\Master\JenisSuratModel;
use App\Models\Master\UserModel;
use App\Traits\TraitsController;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    use TraitsController;

    public function index(Request $request)
    {
        $search = $request->query('search');
        $data = SuratModel::selectData()
            ->when($search, function ($query, $search) {
                $query->where('nomor_surat', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transaction.surat.index', [
            'data' => $data,
            'title' => 'Surat',
            'breadcrumb' => ['Transaksi', 'Surat'],
        ]);
    }

    public function getData(Request $request)
    {
        $search = $request->query('search');
        $data = SuratModel::selectData()
            ->when($search, function ($query, $search) {
                $query->where('nomor_surat', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return view('transaction.surat.data', ['data' => $data])->render();
        }

        return redirect()->route('transaction.surat.index');
    }

    public function addData()
    {
        return view('transaction.surat.create', [
            'jenisSurat' => JenisSuratModel::selectData()->get(),
            'users' => UserModel::selectData()->get(),
            'title' => 'Tambah Surat'
        ]);
    }

    public function createData(Request $request)
    {
        try {
            $validator = SuratModel::validasiData([
                'nomor_surat' => 'required|string|max:50',
                'tanggal_surat' => 'required|date',
                'pengirim' => 'required|string|max:100',
                'penerima' => 'required|string|max:100',
                'fk_m_jenis_surat' => 'required|exists:m_jenis_surat,id',
                // 'fk_m_user' dihapus dari validasi
            ], $request->all());

            if ($validator->fails()) {
                return $this->redirectValidationError($validator);
            }

            // Ambil semua input
            $data = $request->all();
            // Tambahkan user yang sedang login
            $data['fk_m_user'] = Auth::user()->id;

            SuratModel::createData($data);

            return $this->redirectSuccess(route('transaction.surat.index'), 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Tambah Data');
        }
    }


    public function editData($id)
    {
        $detail = SuratModel::findOrFail($id);

        return view('transaction.surat.edit', [
            'data' => $detail,
            'jenisSurat' => JenisSuratModel::selectData()->get(),
            'users' => UserModel::selectData()->get(),
            'title' => 'Edit Surat'
        ]);
    }

    public function updateData(Request $request, $id)
    {
        try {
            $validator = SuratModel::validasiData([
                'nomor_surat' => 'required|string|max:50',
                'tanggal_surat' => 'required|date',
                'pengirim' => 'required|string|max:100',
                'penerima' => 'required|string|max:100',
                'fk_m_jenis_surat' => 'required|exists:m_jenis_surat,id',
                'fk_m_user' => 'required|exists:m_user,id'
            ], $request->all());

            if ($validator->fails()) {
                return $this->redirectValidationError($validator);
            }

            SuratModel::updateData($id, $request->all());
            return $this->redirectSuccess(route('transaction.surat.index'), 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Update Data');
        }
    }

    public function detailData($id)
    {
        $detail = SuratModel::with(['jenisSurat', 'user'])->findOrFail($id);

        return view('transaction.surat.detail', [
            'data' => $detail,
            'title' => 'Detail Surat'
        ]);
    }

    public function deleteData(Request $request, $id)
    {
        $detail = SuratModel::findOrFail($id);

        if ($request->isMethod('get')) {
            return view('transaction.surat.delete', [
                'data' => $detail,
                'title' => 'Hapus Surat'
            ]);
        }

        try {
            SuratModel::deleteData($id);
            return $this->redirectSuccess(route('transaction.surat.index'), 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Hapus Data');
        }
    }
}

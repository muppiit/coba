<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\JenisSuratModel;
use App\Traits\TraitsController;

class JenisSuratController extends Controller
{
    use TraitsController;

    public function index(Request $request)
    {
        $search = $request->query('search');
        $data = JenisSuratModel::selectData()
            ->when($search, function ($query, $search) {
                $query->where('nama_jenis', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('master.jenis_surat.index', [
            'data' => $data,
            'title' => 'Jenis Surat',
            'breadcrumb' => ['Master Data', 'Jenis Surat'],
        ]);
    }

    public function getData(Request $request)
    {
        $search = $request->query('search');
        $data = JenisSuratModel::selectData($search)->paginate(10);

        if ($request->ajax()) {
            return view('master.jenis_surat.data', ['data' => $data])->render();
        }

        return redirect()->route('master.jenis_surat.index');
    }

    public function addData()
    {
        return view('master.jenis_surat.create', [
            'title' => 'Tambah Jenis Surat'
        ]);
    }

    public function createData(Request $request)
    {
        try {
            $validator = JenisSuratModel::validasiData([
                'nama_jenis' => 'required|string|max:100',
                'deskripsi' => 'nullable|string'
            ], $request->all());

            if ($validator->fails()) {
                return $this->redirectValidationError($validator);
            }

            JenisSuratModel::createData($request->all());
            return $this->redirectSuccess(route('master.jenis_surat.index'), 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Tambah Data');
        }
    }

    public function editData($id)
    {
        $detail = JenisSuratModel::findOrFail($id);

        return view('master.jenis_surat.edit', [
            'data' => $detail,
            'title' => 'Edit Jenis Surat'
        ]);
    }

    public function updateData(Request $request, $id)
    {
        try {
            $validator = JenisSuratModel::validasiData([
                'nama_jenis' => 'required|string|max:100',
                'deskripsi' => 'nullable|string'
            ], $request->all());

            if ($validator->fails()) {
                return $this->redirectValidationError($validator);
            }

            JenisSuratModel::updateData($id, $request->all());
            return $this->redirectSuccess(route('master.jenis_surat.index'), 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Update Data');
        }
    }

    public function detailData($id)
    {
        $detail = JenisSuratModel::findOrFail($id);

        return view('master.jenis_surat.detail', [
            'data' => $detail,
            'title' => 'Detail Jenis Surat'
        ]);
    }

    public function deleteData(Request $request, $id)
    {
        $detail = JenisSuratModel::findOrFail($id);

        if ($request->isMethod('get')) {
            return view('master.jenis_surat.delete', [
                'data' => $detail,
                'title' => 'Hapus Jenis Surat'
            ]);
        }

        try {
            JenisSuratModel::deleteData($id);
            return $this->redirectSuccess(route('master.jenis_surat.index'), 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Hapus Data');
        }
    }
}

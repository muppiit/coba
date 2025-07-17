<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TraitsModel;

class JenisSuratModel extends Model
{
    use TraitsModel;

    protected $table = 'm_jenis_surat';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = array_merge($this->fillable, $this->getCommonFields());
    }

    public static function selectData($search = false)
    {
        $query = self::where('isDeleted', 0);
        if ($search) {
            $query->where('nama_jenis', 'like', "%$search%");
        }
        return $query->orderBy('created_at', 'desc');
    }

    public static function createData(array $data)
    {
        return self::create($data);
    }

    public static function updateData($id, array $data)
    {
        $model = self::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public static function deleteData($id)
    {
        $model = self::findOrFail($id);
        return $model->delete();
    }

    public static function validasiData(array $rules, array $data)
    {
        return validator($data, $rules);
    }
}

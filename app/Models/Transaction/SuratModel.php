<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TraitsModel;
use App\Models\Master\JenisSuratModel;
use App\Models\Master\UserModel;

class SuratModel extends Model
{
    use TraitsModel;

    protected $table = 't_surat';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim',
        'penerima',
        'fk_m_jenis_surat',
        'fk_m_user',
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
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%$search%")
                    ->orWhere('pengirim', 'like', "%$search%")
                    ->orWhere('penerima', 'like', "%$search%");
            });
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

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSuratModel::class, 'fk_m_jenis_surat');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'fk_m_user');
    }
}

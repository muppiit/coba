<?php

namespace App\Models\Master;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\TraitsModel;

class UserModel extends Authenticatable
{
    use TraitsModel;

    protected $table = 'm_user';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'username',
        'password',
        'role',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = array_merge($this->fillable, $this->getCommonFields());
    }

    public static function selectData()
    {
        return self::where('isDeleted', 0);
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

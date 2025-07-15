<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait BaseModelFunction
{
    protected static $defaultPerPage = 1;

    protected $commonFields = [
        'isDeleted',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    protected static function bootBaseModelFunction()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::user()->username ?? 'system';
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->username ?? 'system';
            $model->updated_at = now();
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::user()->username ?? 'system';
            $model->deleted_at = now();
        });
    }

    public function delete()
    {
        $this->deleted_by = Auth::user()->username ?? 'system';
        $this->deleted_at = now();
        if ($this->isDeleted === 0) {
            $this->isDeleted = 1;
        }
        $this->save();

        $this->fireModelEvent('deleted', false);

        return true;
    }

    public static function paginateResults(Builder $query, $perPage = null)
    {
        $perPage = $perPage ?? static::$defaultPerPage;
        return $query->paginate($perPage);
    }

    public function getCommonFields()
    {
        return $this->commonFields;
    }
}

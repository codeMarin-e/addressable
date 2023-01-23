<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Marinar\Marinar\Traits\MacroableModel;
use Marinar\Orderable\Traits\Orderable;

class Address extends Model {
    use MacroableModel;
    use Orderable;

    protected static function boot() {
        parent::boot();
        static::updated( static::class.'@onUpdated_updateAddressableCache' );
    }

    public function sameQryWheres () {
        return [
            'addressable_type' => $this->addressable_type,
            'addressable_id' => $this->addressable_id,
            'type' => $this->type,
        ];
    }
    public function orderableQryBld ($qryBld = null) {
        $qryBld = $qryBld? clone $qryBld : $this;
        return $qryBld->where($this->sameQryWheres());
    }

    protected $guarded = [];

//        protected $touches = ['addressable'];

    public function addressable() {
        return $this->morphTo();
    }

    public function getFullNameAttribute() {
        return "{$this->fname} {$this->lname}";
    }

    public function merge(self $address, $except = [], $only = false) {
        $attributes = is_array($only)? $address->only($only) : $address->getAttributes();
        $this->update(Arr::except($attributes, array_merge($except, [
            'id',
            'type',
            'addressable_id',
            'addressable_type',
            'ord',
            'created_at',
            'updated_at',
        ])));
    }

    public function onUpdated_updateAddressableCache($model) {
        if( $model->addressable )
            $model->addressable->updateAddressableCache($model, $model->getOriginal('type'));
    }


}

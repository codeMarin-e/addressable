<?php
    namespace Marinar\Addressable\Traits;

    use App\Models\Address;

    trait Addressable {

        public $addresses_cache = null; //memory cache

        public static function bootAddressable() {
            static::deleting( static::class.'@onDeleting_addresses' );
        }

        public function addressableCache() {
            foreach($this->addresses()->get() as $address) {
                $this->addresses_cache[$address->type] = $address;
            }
        }

        public function updateAddressableCache(Address $address, $oldType = null) {
            if(!is_null($oldType) && isset($this->addresses_cache[$oldType])) {
                unset($this->addresses_cache[$oldType]);
            }
            $this->addresses_cache[$address->type] = $address;
        }

        public function clearAddressableCache() {
            $this->addresses_cache = null; //clear the memory cache
        }


        public function getAddressAttribute() {
            return $this->getAddress();
        }

        public function getAddress($attrs = [], $type = 'main', $forceCreate = false) {
            if(!$forceCreate && is_null($this->addresses_cache)) {
                $this->addressableCache();
            }
            if(!isset($this->addresses_cache[$type])) {
                $this->addresses_cache[$type] = $this->addresses()->create($attrs);
            }
            return $this->addresses_cache[$type];
        }

        public function addresses() {
            return $this->morphMany( Address::class, 'addressable');
        }

        public function onDeleting_addresses($model) {
            $this->clearAddressableCache();
            foreach($model->addresses()->get() as $address) {
                $address->delete();
            }
        }



    }

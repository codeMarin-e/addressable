<?php
    namespace Marinar\Addressable\Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\Address;
    use Marinar\Addressable\MarinarAddressable;

    class MarinarAddressableRemoveSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;
            static::$packageName = 'marinar_addressable';
            static::$packageDir = MarinarAddressable::getPackageMainDir();

            $this->autoRemove();

            $this->refComponents->info("Done!");
        }

        public function clearDB() {
            $this->refComponents->task("Clear DB rows", function() {
                $addresses = Address::get();
                foreach ($addresses as $address) {
                    $address->delete();
                }
                return true;
            });
        }
    }

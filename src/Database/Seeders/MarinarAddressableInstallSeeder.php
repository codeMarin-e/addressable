<?php
    namespace Marinar\Addressable\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Marinar\Addressable\MarinarAddressable;

    class MarinarAddressableInstallSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public static function configure() {
            static::$packageName = 'marinar_addressable';
            static::$packageDir = MarinarAddressable::getPackageMainDir();
        }

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;

            $this->autoInstall();

            $this->refComponents->info("Done!");
        }

    }

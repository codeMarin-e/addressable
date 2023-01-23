<?php
    namespace Marinar\Addressable\Database\Seeders;

    use Illuminate\Database\Seeder;

    class MarinarAddressableInstallSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;
            static::$packageName = 'marinar_addressable';
            static::$packageDir = MarinarAddressable::getPackageMainDir();

            $this->autoInstall();

            $this->refComponents->info("Done!");
        }

    }

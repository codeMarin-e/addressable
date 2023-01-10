<?php
    namespace Marinar\Addressable\Database\Seeders;

    use App\Models\Package;
    use Illuminate\Database\Seeder;
    use Symfony\Component\Process\Exception\ProcessFailedException;
    use Symfony\Component\Process\Process;

    class MarinarAddressableInstallSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public function run() {
            $this->getRefComponents();
            $this->stubFiles();
            $this->dbMigrate();
            $this->refComponents->info("Done!");
        }


        private function dbMigrate() {
            $this->dbMigrateDir(implode(DIRECTORY_SEPARATOR, [
                \Marinar\Addressable\MarinarAddressable::getPackageMainDir(),
                'stubs', 'project', 'database', 'migrations',
            ]));
        }

        private function stubFiles() {
            $this->copyStubs(\Marinar\Addressable\MarinarAddressable::getPackageMainDir().DIRECTORY_SEPARATOR.'stubs');
        }

    }

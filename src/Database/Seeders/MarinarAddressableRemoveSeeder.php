<?php
    namespace Marinar\Addressable\Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\Address;

    class MarinarAddressableRemoveSeeder extends Seeder {
        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public function run() {
            $this->getRefComponents();
            $this->clearDBrows();
            $this->clearFiles();
            $this->dbMigrateRollback();
            $this->refComponents->info("Done!");
        }

        public function clearDBrows() {
            $this->refComponents->task("Clear DB rows", function() {
                $addresses = Address::get();
                foreach ($addresses as $address) {
                    $address->delete();
                }
                return true;
            });
        }

        private function clearFiles() {
//            if(!$this->command->confirm('Are you sure you want to delete `addressable` files?', false)) return false;
            $this->refComponents->task("Clear stubs", function() {
                $copyDir = \Marinar\Addressable\MarinarAddressable::getPackageMainDir().DIRECTORY_SEPARATOR.'stubs';
                static::removeStubFiles($copyDir, $copyDir, true);
                return true;
            });
        }

        private function dbMigrateRollback() {
            $this->dbMigrateRollbackDir(implode(DIRECTORY_SEPARATOR, [
                \Marinar\Addressable\MarinarAddressable::getPackageMainDir(),
                'stubs', 'project', 'database', 'migrations',
            ]));
        }
    }

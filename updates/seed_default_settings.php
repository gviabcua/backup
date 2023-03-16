<?php namespace Gviabcua\Backup\Updates;

use Winter\Storm\Database\Updates\Seeder;
use Gviabcua\Backup\Models\Settings;

class SeedDefaultSettings extends Seeder
{
    public function run()
    {
        $pathsToInclude = [
            ['path' => 'themes'],
            ['path' => 'plugins'],
            ['path' => 'config'],
            ['path' => 'opt'],
        ];
        $pathsToExclude = [
            ['path' => '/vendor'],
            ['path' => '/plugins/rainlab'],
            ['path' => '/storage/logs'],
            ['path' => '/storage/app/backup-temp'],
            ['path' => '/storage/app/gviabcua-backup'],
            ['path' => '/storage/app/uploads/gviabcua-backup'],
            ['path' => '/storage/temp'],
            ['path' => '/storage/cms'],

        ];
        Settings::set('include_files', $pathsToInclude);
        Settings::set('exclude_files', $pathsToExclude);
        Settings::set('maximum_execution_time', 600);
    }
}

<?php namespace Gviabcua\Backup;

use File;
use Illuminate\Support\Facades\Config;
use Log;
use Storage;
use Gviabcua\Backup\Models\Settings;

class Repository
{
    public function getAll()
    {
        return array_merge($this->getLocalBackups());
    }

    public function getLocalBackups()
    {
        $backups = [];
        $localBackupFiles = array_values(array_diff(scandir(Settings::getBackupsPath()), ['.', '..']));
        foreach ($localBackupFiles as $index => $file) {
            $backups[$index]['storage'] = 'Local';
            $backups[$index]['fileInfo'] = pathinfo(Settings::getBackupsPath().'/'.$file);
            $backups[$index]['size'] = ceil(filesize(Settings::getBackupsPath().'/'.$file) / 1024);
            $backups[$index]['lastModified'] = date('d.m.Y', filemtime(Settings::getBackupsPath().'/'.$file));
        }

        return $backups;
    }

    /**
     * Will be removed in the future.
     */
    public function getLocalBackupsInTheOldPath()
    {
        $backups = [];
        $path = storage_path('app/gviabcua-backup');
        if (File::exists($path)) {
            $localBackupFiles = array_values(array_diff(scandir($path), ['.', '..']));
            foreach ($localBackupFiles as $index => $file) {
                $backups[$index]['storage'] = 'Local';
                $backups[$index]['fileInfo'] = pathinfo($path.'/'.$file);
                $backups[$index]['size'] = ceil(filesize($path.'/'.$file) / 1024);
                $backups[$index]['lastModified'] = date('d.m.Y', filemtime($path.'/'.$file));
            }
        }

        return $backups;
    }

}

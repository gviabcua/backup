<?php namespace Gviabcua\Backup;

use App;
use Backend;
use Config;
use Gviabcua\Backup\Models\Settings;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;
use System\Classes\SettingsManager;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Backup',
            'description' => 'Backup files and database of Winter CMS',
            'author' => 'Panagiotis Koursaris & Gviabcua mod',
            'icon' => 'icon-floppy-o',
            'homepage' => 'https://github.com/panakour/oc-backup-plugin',
        ];
    }

    public function registerNavigation()
    {
        return [
            'backup' => [
                'label' => 'Backup',
                'url' => Backend::url('gviabcua/backup/backups'),
                'icon' => 'icon-floppy-o',
                'iconSvg' => 'plugins/gviabcua/backup/assets/images/backup-icon.svg',
                'order' => 200,
                'permissions' => ['gviabcua.backup.access'],
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label' => 'Backup',
                'icon' => 'icon-floppy-o',
                'description' => 'Configure the backup system.',
                'category' => SettingsManager::CATEGORY_SYSTEM,
                'class' => Settings::class,
                'order' => 600,
                'permissions' => ['gviabcua.backup.access'],
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'gviabcua.backup.access' => [
                'label' => 'Manage backups',
                'tab' => 'Backup'
            ],
        ];
    }

    public function boot()
    {
        $this->bootPackages();
    }

    public function bootPackages()
    {
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));

        $aliasLoader = AliasLoader::getInstance();

        $packages = Config::get($pluginNamespace.'::packages');

        foreach ($packages as $name => $options) {
            if (! empty($options['config']) && ! empty($options['config_namespace'])) {
                Config::set($options['config_namespace'], $options['config']);
            }

            if (! empty($options['providers'])) {
                foreach ($options['providers'] as $provider) {
                    App::register($provider);
                }
            }

            if (! empty($options['aliases'])) {
                foreach ($options['aliases'] as $alias => $path) {
                    $aliasLoader->alias($alias, $path);
                }
            }
        }
    }
}

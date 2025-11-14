<?php

declare(strict_types=1);

namespace WebBook\GDPR;

use System\Classes\PluginBase;
use System\Classes\PluginManager;
use WebBook\GDPR\Models\CookiesSettings;

class Plugin extends PluginBase
{
    public function boot()
    {
        // dump( CookiesSettings::get('cookies') );
    }

    public function registerSettings()
    {
        return [
            'cookies' => [
                'label' => 'webbook.gdpr::lang.settings.cookies.name',
                'description' => 'webbook.gdpr::lang.settings.cookies.description',
                'category' => 'GDPR',
                'icon' => 'icon-desktop',
                'class' => 'WebBook\GDPR\Models\CookiesSettings',
                'keywords' => 'gdpr cookies bar consent',
                'order' => 990,
                'permissions' => ['webbook.gdpr.access_cookies_settings'],
            ],
        ];
    }

    public function registerComponents()
    {
        return [
            'WebBook\GDPR\Components\CookiesBar' => 'cookiesBar',
            'WebBook\GDPR\Components\CookiesManage' => 'cookiesManage',
        ];
    }

    public function registerMarkupTags()
    {
        $settings = CookiesSettings::instance();
        $pluginManager = PluginManager::instance()->findByIdentifier('Rainlab.Translate');

        if ($pluginManager && ! $pluginManager->disabled) {
            $settings->translateContext(\RainLab\Translate\Classes\Translator::instance()->getLocale());
        }

        return [
            'filters' => [],
            'functions' => [
                'cookiesSettingsGet' => function ($value, $default = null) use ($settings) {
                    if (empty($settings->{$value})) {
                        return $default;
                    }

                    return $settings->{$value};
                },
            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'WebBook\GDPR\FormWidgets\ImportPreset' => 'importpreset',
            'WebBook\GDPR\FormWidgets\ExportPreset' => 'exportpreset',
        ];
    }

    public function registerPageSnippets()
    {
        return [
            '\WebBook\GDPR\Components\CookiesManage' => 'cookiesManage',
        ];
    }
}

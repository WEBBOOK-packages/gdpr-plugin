<?php

declare(strict_types=1);

namespace WebBook\GDPR\Models;

class CookiesSettings extends \Model
{
    public $implement = [
        'System.Behaviors.SettingsModel',
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    public $translatable = [
        'cookies',
        'cookies_bar_title',
        'cookies_bar_content',
        'cookies_bar_buttons',
        'cookies_manage_title',
        'cookies_manage_content',
        'set_cookies_lifetime_days',
    ];

    protected $jsonable = [
        'cookies',
        'cookies_bar_buttons',
    ];

    public $requiredPermissions = ['webbook.gdpr.access_cookies_settings'];

    public $settingsCode = 'webbook_gdpr_cookies_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'set_cookies_lifetime_days' => 'numeric',
    ];

    public static function getSGCookies($sgCookiesPrefix = 'sg-cookies')
    {
        $sgCookiesPrefix = CookiesSettings::getSGCookiesLocalePrefix($sgCookiesPrefix);

        $sgCookies = [];

        $sgCookies['consent'] = ! empty($_COOKIE[$sgCookiesPrefix.'-state']);

        foreach (CookiesSettings::get('cookies', []) as $cookie) {
            // REQUIRED are always ON
            if (! empty($cookie['required'])) {
                $sgCookies[$cookie['slug']] = 1;
                continue;
            }

            // DEFAULT ENABLED cookies are ON only when no general consent or when explicitly allowed
            if (! empty($cookie['default_enabled']) and empty($_COOKIE[$sgCookiesPrefix.'-state'])) {
                $sgCookies[$cookie['slug']] = 1;
                continue;
            }

            // ALL OTHER by its consent state
            if (! empty($_COOKIE[$sgCookiesPrefix.'-'.$cookie['slug']])) {
                $sgCookies[$cookie['slug']] = 1;
            }
        }

        return $sgCookies;
    }

    public static function getSGCookiesLocalePrefix($sgCookiesPrefix = '')
    {
        if (CookiesSettings::get('set_cookies_with_locale', false)) {
            $sgCookiesPrefix = $sgCookiesPrefix.'-'.\App::getLocale();
        }

        return $sgCookiesPrefix;
    }
}

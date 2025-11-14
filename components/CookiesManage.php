<?php

declare(strict_types=1);

namespace WebBook\GDPR\Components;

use Cms\Classes\ComponentBase;
use WebBook\GDPR\Models\CookiesSettings;

class CookiesManage extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'webbook.gdpr::lang.components.cookies_manage.name',
            'description' => 'webbook.gdpr::lang.components.cookies_manage.description',
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun()
    {
        $this->page['sgCookies'] = CookiesSettings::getSGCookies();
        $this->page['sgCookiesLocalePrefix'] = CookiesSettings::getSGCookiesLocalePrefix();
    }

    public function onRender()
    {
    }
}

<?php

declare(strict_types=1);

namespace WebBook\GDPR\Components;

use Cms\Classes\ComponentBase;
use WebBook\GDPR\Models\CookiesSettings;

class CookiesBar extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'webbook.gdpr::lang.components.cookies_bar.name',
            'description' => 'webbook.gdpr::lang.components.cookies_bar.description',
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun()
    {
        if (CookiesSettings::get('cookies_bar_add_styles', null)) {
            switch (CookiesSettings::get('cookies_bar_add_styles', null)) {
                case 2:
                    $this->addCss(['assets/cookiesbar/cookiesbar-topline.less']);

                    break;

                case 3:
                    $this->addCss(['assets/cookiesbar/cookiesbar-topline.less', 'assets/cookiesbar/cookiesbar-topline-container.less']);

                    break;

                default:
                    $this->addCss(['assets/cookiesbar/cookiesbar.less']);

                    break;
            }
        }

        $this->page['sgCookies'] = CookiesSettings::getSGCookies();
        $this->page['sgCookiesLocalePrefix'] = CookiesSettings::getSGCookiesLocalePrefix();
    }

    public function onRender()
    {
    }
}

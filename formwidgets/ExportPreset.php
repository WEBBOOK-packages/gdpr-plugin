<?php

declare(strict_types=1);

namespace WebBook\GDPR\FormWidgets;

use Backend\Classes\FormWidgetBase;
use WebBook\GDPR\Models\CookiesSettings;

class ExportPreset extends FormWidgetBase
{
    public $label = '';
    public $description = '';

    /**
     * @var string a unique alias to identify this widget
     */
    protected $defaultAlias = 'exportpreset';

    public function render()
    {
        return $this->makePartial('exportpreset');
    }

    public function onExportPreset()
    {
        $path = base_path(post('file_name'));

        $data = CookiesSettings::instance()->toArray();

        if (empty($data['value'])) {
            \Log::error('SG: Settings data was not found!');
            \Flash::error(trans('webbook.gdpr::lang.formwidgets.exportpreset.flash.export_error'));

            return false;
        }

        try {
            $dataParsed = \Yaml::render($data['value']);
        } catch (\Exception $e) {
            \Log::error('SG: Error parsing settings data! '.$e->getMessage());
            \Flash::error(trans('webbook.gdpr::lang.formwidgets.exportpreset.flash.parse_error'));

            return false;
        }

        try {
            \File::put($path, $dataParsed);
        } catch (\Exception $e) {
            \Log::error('SG: Error saving exported data! '.$e->getMessage());
            \Flash::error(trans('webbook.gdpr::lang.formwidgets.exportpreset.flash.export_error'));

            return false;
        }

        \Log::info('SG: Data successfully exported!');
        \Flash::success(trans('webbook.gdpr::lang.formwidgets.exportpreset.flash.export_successfull'));
    }
}

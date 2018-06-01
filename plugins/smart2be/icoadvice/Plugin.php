<?php namespace Smart2be\IcoAdvice;

use System\Classes\PluginBase;
use Backend;
use System\Classes\SettingsManager;
use Smart2be\IcoAdvice\Components\Icos;
use Smart2be\IcoAdvice\Components\Icolist;


class Plugin extends PluginBase
{
     public function registerComponents()
    {
        return [
            '\Smart2be\IcoAdvice\Components\Icos' => 'icoForm',
            '\Smart2be\IcoAdvice\Components\IcoEdit' => 'icoEdit',
            '\Smart2be\IcoAdvice\Components\Icolist' => 'icoList',
            '\Smart2be\IcoAdvice\Components\IcoCard' => 'icoCard'
        ];
    }
    
    public function registerSettings()
    {
    	return [
            'names' => [
                'label'       => 'smart2be.icoadvice::lang.plugin.name',
                'description' => 'smart2be.icoadvice::lang.plugin.description',
                'url' => Backend::url('smart2be/icoadvice/ico'),
                'icon'        => 'icon-list',
                'category'    => SettingsManager::CATEGORY_CMS, 
                'permissions' => ['smart2be.yclcr.*'],
                'order' => 200
            ]
        ];
    }
}

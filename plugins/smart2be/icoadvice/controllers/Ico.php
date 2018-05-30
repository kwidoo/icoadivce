<?php 
namespace Smart2be\IcoAdvice\Controllers;

use BackendMenu;
use Config;

use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Smart2be\Icoadvice\Models;



class Ico extends Controller
{
    public $implement = [        
    	'Backend\Behaviors\ListController',        
    	'Backend\Behaviors\FormController',
    	'Backend.Behaviors.RelationController'
    
   	];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $layout = '$/smart2be/icoadvice/assets/layouts/adminlte';
    
    public $bodyClass = 'compact-container';


    public function __construct()
    {
        parent::__construct();
       
       // BackendMenu::setContext('October.System', 'system', 'settings');
      //  SettingsManager::setContext('Smart2be.icoadvice', 'names');
    }

}

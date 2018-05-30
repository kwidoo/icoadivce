<?php 
namespace Smart2be\IcoAdvice\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Smart2be\IcoAdvice\Models;



class Goals extends Controller
{
 	public $implement = [        
    	'Backend\Behaviors\ListController',        
    	'Backend\Behaviors\FormController',
    
   	];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    
    public function __construct()
    {
        parent::__construct();
    }
}

<?php namespace Smart2be\IcoAdvice\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Smart2be\IcoAdvice\TeamLinks;

class Team extends Controller
{
    public $implement = [        
    	'Backend\Behaviors\ListController',        
    	'Backend\Behaviors\FormController',        
    //	'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.RelationController'
   
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
   // public $reorderConfig = 'config_reorder.yaml';
        public $relationConfig = 'config_relation.yaml';


    public function __construct()
    {
 //   	TeamLinks::create([
   // 		'team_id' => 1,
    //		'type' => 1,
    //		'url' => 'facebook.com'
    //	])->save();

        parent::__construct();
        BackendMenu::setContext('Smart2be.IcoAdvice', 'main-menu-item');
    }
}

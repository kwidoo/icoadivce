<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
use Smart2be\IcoAdvice\Controllers\Ico as IcoController;
use \Smart2be\IcoAdvice\Models\Ico;
use Redirect;

class IcoList extends ComponentBase
{
	public function componentDetails()
	{
	    return [
	        'name' => 'Ico List Dashboard',
	        'description' => 'Backend form used in the front-end'
	    ];
	}
    public function onRun()
    {
    	$this->page['ico'] = Ico::whereHas('users', function($query){
    		$query->where('user_id','=','1');
    	})->get();
    }
    public function onIcoCreate(){
    	return Redirect::to('dashboard/create');
    }



}
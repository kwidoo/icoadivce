<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
use \Smart2be\IcoAdvice\Models\Ico;
use Redirect;
use Auth;

class IcoList extends ComponentBase
{
	public function componentDetails()
	{
	    return [
	        'name' => 'ICO List Dashboard',
	        'description' => 'Front-end, Dashboard displays list of ICOs'
	    ];
	}
    public function onRun(){
        $user = Auth::getUser();
        if ($user->ico) {
            $this->page['ico'] = $user->ico;
        }
    }
    public function onIcoCreate(){
    	return Redirect::to('/dashboard/create');
    }
    public function onIcoDelete(){
        
    }



}
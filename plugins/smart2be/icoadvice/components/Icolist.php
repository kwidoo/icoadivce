<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
use Smart2be\IcoAdvice\Controllers\Ico as IcoController;
use \Smart2be\IcoAdvice\Models\Ico;
use Redirect;
use Auth;

class IcoList extends ComponentBase
{
	public function componentDetails()
	{
	    return [
	        'name' => 'Ico List Dashboard',
	        'description' => 'Backend form used in the front-end'
	    ];
	}
    public function onRun(){
        $user = Auth::getUser();
        if ($user) {
            if ($user->ico) {
                $this->page['ico'] = $user->ico;

                foreach ($user->ico as $ico){
                    if ($ico->logo)
                        $link[$ico->id] = $ico->logo->getPath();
                    else
                        $link[$ico->id] = '/storage/app/uploads/public/5b0/ecd/0bd/5b0ecd0bd7abe729741586.png';
                }
                if (isset($link)) 
                    $this->page['link'] = $link;
                
            }
        } else {
            return Redirect::to('/login');
        }
    }


    public function onIcoCreate(){
    	return Redirect::to('dashboard/create');
    }

    public function onIcoDelete(){
        
    }



}
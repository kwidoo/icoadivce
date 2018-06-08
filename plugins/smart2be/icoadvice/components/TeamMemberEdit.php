<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
use \Smart2be\IcoAdvice\Models\Ico;
use Redirect;
use Storage;
use System\Models\File;
use Auth;
use Flash;
use Log;
use Input;

class TeamEdit extends ComponentBase
{

  	public function componentDetails(){
  	    return [
  	        'name' => 'Team Member Edit Page',
  	        'description' => 'Backend form used in the front-end'
  	    ];
  	}

    public function onRun(){
        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();
        if ($ico) {
            $this->page['team'] = $ico->team;
        } else {
          return Redirect::to('dashboard');
        } 
    }

    public function onSave(){
        Log::info('Logging: '.implode(Input::all()));

      
    }

    public function onPublish(){
      $user = Auth::getUser();
     
    }

    public function onTeamEdit(){
        return Redirect::to('dashboard/team/'.$this->param('id'));
    }

}
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
  	        'name' => 'Ico Team Edit Page',
  	        'description' => 'Backend form used in the front-end'
  	    ];
  	}

    public function onRun(){
        $this->addJs('assets/js/uploader.js');
        $this->addJs('assets/js/checker.js');
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

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();
        if ($ico) {

            if (post('file-upload')) 
            {
                /* Если меняется лого сохраняем его */
                $content = explode(',',post('file-upload'));
                $filetype = explode(';', explode('/', $content[0])[1])[0];
                $filename = md5(uniqid(rand(), true)).'.'.$filetype;
                $file = base64_decode($content[1]); 
                Storage::put('media/logo/'.$filename, $file);

                $file = new File;
                $file->data = storage_path('/app/media/logo/'.$filename);
                $file->is_public = true;
                $file->save();

                $ico->logo()->add($file);
            }
            $ico->name = post('name');
            $ico->tiker = post('tiker');
            $ico->soft_cap = post('soft_cap');
            $ico->hard_cap = post('hard_cap');
            $ico->cap_nomination = post('cap_nomination');
            $ico->other = post('other');
            $ico->slogan = post('slogan');
            $ico->short = post('short');
            $ico->description = post('description');
            $ico->save();
          //  Flash::success('Data successfully saved!');

        } else {

          return Redirect::to('dashboard');
        }

        if (post('action') == "update") return;
        if (post('action') == "close") return Redirect::to('dashboard');
    }

    public function onPublish(){
      $user = Auth::getUser();
      $ico = $user->ico->where('id','=',$this->param('id'))->first();  
      if ($ico) {
        if ($ico->status == 0) 
            $ico->status = 1; 
        else 
            $ico->status = 0;  
        $ico->save();
      }    
    }

    public function onTeamEdit(){
        return Redirect::to('dashboard/team/'.$this->param('id'));
    }

}
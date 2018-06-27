<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
use Smart2be\IcoAdvice\Models\Ico;
use Log;
use Auth;
use Input;
use Redirect;
use Storage;
use System\Models\File;

class Icos extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Ico Create Form',
            'description' => 'Front-end, Dashboard Create Form'
        ];
    }
    public function onSave()
    {
        $user = Auth::getUser();
        $ico = new Ico;
        $ico->name = post('name');
        $ico->tiker = post('tiker'); 
        $ico->users = [$user];
        $ico->save();
        return Redirect::to('dashboard/edit/'.$ico->id);
    }
}
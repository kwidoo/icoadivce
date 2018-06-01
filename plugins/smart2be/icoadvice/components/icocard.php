<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
//use Smart2be\IcoAdvice\Controllers\Ico as IcoController;
use \Smart2be\IcoAdvice\Models\Ico;
use Redirect;
use Storage;
use System\Models\File;
use Auth;
use Flash;
use Log;
use Input;

class IcoCard extends ComponentBase
{
 
  	public function componentDetails(){
  	    return [
  	        'name' => 'Ico Card On Main Page',
  	        'description' => 'Frontend'
  	    ];
  	}

    public function onRun(){
        $ico = Ico::where('id','=','38');
        $this->page['ico'] = $ico;
    }

  


}
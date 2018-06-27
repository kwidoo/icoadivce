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

class ListItems extends ComponentBase
{ 
    public function componentDetails()
    {
        return [
            'name' => 'ICO General List',
            'description' => 'Front-end General ICO Listing'
        ];
    }
    public function onRun(){
        $ico = ICO::where('featured_id','=',0)
                  ->where('end_date','>=',date("Y-m-d H:i:s"))
                  ->where('start_date','<=',date("Y-m-d H:i:s"))
                  ->orderBy('end_date', 'ASC')->get();

        $ico_upcoming = ICO::where('featured_id','=',0)
                  ->where('start_date','>',date("Y-m-d H:i:s"))
                  ->orderBy('start_date', 'ASC')->get();
                  
        $this->page['ico'] = $ico;
        $this->page['upcoming'] = $ico_upcoming;
        $this->page['now'] = date("Y-m-d H:i:s");
    }
}


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

class MainItem extends ComponentBase
{

    public function onRun(){
        $ico = ICO::where('id',$this->param('id'))->first();


        $differ1 = strtotime($ico->end_date) - strtotime(date('Y-m-d H:i:s'));
        $differ2 = strtotime($ico->start_date) - strtotime(date('Y-m-d H:i:s'));

        $this->page['ico'] = $ico;
        if ($differ1 < 0) {
            $this->page['status'] = 'ended';
            $this->page['counter'] = 0;
        }
        if ($differ2 > 0) {
            $this->page['status'] = 'upcoming';
            $this->page['counter'] = 1;
            $this->page['tm'] = strtotime($ico->start_date);

        }
       if ($differ1 > 0 and $differ2 < 0) {
            $this->page['status'] = 'active';  
            $this->page['counter'] = 2;
            $this->page['tm'] = strtotime($ico->end_date);

        }

        
    }


    public function componentDetails()
    {
        return [
            'name' => 'Main Item Upcoming',
            'description' => 'Frontend Main Item'
        ];
    }
}
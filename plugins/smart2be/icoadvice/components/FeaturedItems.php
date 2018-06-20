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

class FeaturedItems extends ComponentBase
{

    public function onRun(){
        $ico = ICO::where('featured_id','1')
            ->orderBy('end_date', 'ASC')
            ->get();

        $this->page['ico'] = $ico;
        $this->page['now'] = strtotime(date("Y-m-d H:i:s"));
    }



    public function componentDetails()
    {
        return [
            'name' => 'Featured Item Upcoming',
            'description' => 'Frontend Featured Item'
        ];
    }
}
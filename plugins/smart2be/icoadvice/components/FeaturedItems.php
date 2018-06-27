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
   public function defineProperties()
    {
        return [
            'type' => [
                'title'       => 'Type Of List',
                'description' => 'Which list to display',
                'default'     => 'active',
                'type'        => 'dropdown',
                'options'     => ['active'=>'active', 'upcoming'=>'upcoming', 'ended' => 'ended']
            ]
        ];
    }
    public function onRun(){
        
            $ico_active = ICO::where('featured_id','>=', 1)
                    ->where('end_date','>=',date("Y-m-d H:i:s"))
                    ->where('start_date','<=',date("Y-m-d H:i:s"))
                    ->orderBy('end_date', 'ASC')
                    ->get();

            $ico_upcoming = ICO::where('featured_id','>=', 1)
                    ->where('end_date','>=',date("Y-m-d H:i:s"))
                    ->where('start_date','>=',date("Y-m-d H:i:s"))
                    ->orderBy('start_date', 'ASC')
                    ->get();

            $ico_ended = ICO::where('featured_id','>=', 1)
                    ->where('end_date','<',date("Y-m-d H:i:s"))
                    ->where('start_date','<',date("Y-m-d H:i:s"))
                    ->orderBy('start_date', 'ASC')
                    ->get();

        $this->page['ico_active'] = $ico_active;
        $this->page['ico_upcoming'] = $ico_upcoming;
        $this->page['ico_ended'] = $ico_ended;
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
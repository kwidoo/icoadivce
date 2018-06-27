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

class SeoItem extends ComponentBase
{
    public $page;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $canonical_url;
    public $redirect_url;
    public $robot_index;
    public $robot_follow;
    public $hasBlog;

    public $ogTitle;
    public $ogUrl;
    public $ogDescription;
    public $ogSiteName;
    public $ogFbAppId;
    public $ogLocale;
    public $ogImage;

    public function onRun(){
        if ($this->param('id')){
        $ico = ICO::where('id',$this->param('id'))->first();
        if ($ico->name){
        $this->ogTitle = $ico->name;
        $this->ogSiteName = $ico->name." | ICO Advice Guru";
        }
        if ($ico->logo)
        $this->ogImage = $ico->logo->path;
        $this->ogUrl = 'https://icoadivce.guru/ico/'.$ico->id;
        $this->seo_description = $ico->description; 
        $this->ogDescription = $ico->description; 
        $this->robot_index = "index";
        $this->robot_follow = "follow";
        }
    }


    public function componentDetails()
    {
        return [
            'name' => 'SEO Item',
            'description' => 'Frontend Main Item'
        ];
    }
}
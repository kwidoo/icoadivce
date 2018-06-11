<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
use \Smart2be\IcoAdvice\Models\Ico;
use \Smart2be\IcoAdvice\Models\IcoToken;
use \Smart2be\IcoAdvice\Models\IcoTokenPrice;
use \Smart2be\IcoAdvice\Models\IcoPublications;
use \Smart2be\IcoAdvice\Models\IcoPartners;
use \Smart2be\IcoAdvice\Models\IcoLocation;
use \Smart2be\IcoAdvice\Models\IcoDates;
use \Smart2be\IcoAdvice\Models\IcoGoals;
use \Smart2be\IcoAdvice\Models\IcoLinks;
use \Smart2be\IcoAdvice\Models\IcoTimeline;
use \Smart2be\IcoAdvice\Models\Team;
use \Smart2be\IcoAdvice\Models\TeamLinks;
use Redirect;
use Storage;
use System\Models\File;
use Auth;
use Flash;
use Log;
use Input;
use Validator;
use ValidationException;

class IcoEdit extends ComponentBase
{

  	public function componentDetails(){
  	    return [
  	        'name' => 'Ico List Edit Page',
  	        'description' => 'Backend form used in the front-end'
  	    ];
  	}

    public function onRun(){
        $this->addJs('assets/js/uploader.js');
        $this->addJs('assets/js/checker.js');
        $this->addJs('assets/js/ajax-trigger.js');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();
        if ($ico) {
            $this->page['ico'] = $ico;
                if ($ico->logo)
                    $this->page['link'] = $ico->logo->getPath();
                else
                    $this->page['link'] = '/storage/app/uploads/public/5b0/ecd/0bd/5b0ecd0bd7abe729741586.png';
            
           // $this->page['link'] = $ico->logo->getPath();

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

    /**
      * TOKEN PART
      * TODO:
      *     1. translations part
      *     2. check for authentification everywhere
      **/


    /**
      * Renders token popup for Edit (token_id must be present) or for Create
      *
      **/
    public function onTokenEdit(){
        if (post('token_id')){
            $token = IcoToken::find(post('token_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_tokens_popup.htm',
                ['title' => 'Edit Token', 'token' => $token, 'tokenPrice' => $token->tokenPrice])];
        } else
            return ['#modalPopupBody' => $this->renderPartial('@_tokens_popup.htm',['title' => 'Add New Token'])];
    }
    /**
      * Deletes token from list
      *
      * TODO: confirmation
      **/
    public function onTokenDelete(){
        if (post('token_id')){
            $token = IcoToken::find(post('token_id'));
            $token->delete();
            Flash::success('Token Was Deleted');
           
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_tokens' => $this->renderPartial('@_tokens.htm',['ico' => $ico])];
        } 
    }
    /**
      * Saves token to ICO
      *
      * NB! Saves model and prices separately
      *
      * TODO
      *     
      *
      **/
    public function onTokenSave(){
        if (post('id')) {   
            $token = IcoToken::find(post('id'));
        } else {
            $token = new IcoToken;
            $token->ico_id = $this->param('id');
        }
        $token->name = post('name');
        $token->decimal = post('decimal');
        $token->tracker = post('tracker');
        $token->type = post('platform');
        if (post('platform') == 5) 
            $token->other = post('other'); 
        else
            $token->other = "";
        if (post('status') == 'on') 
            $token->status = 1; 
        else
            $token->status = 0;
        $token->save();
        Flash::success('Token Was Updated');

        $data = post();
        $keys = array_keys($data);
        foreach ($keys as $key){
            if (strpos($key, 'price_id') !== false ){
                $pos[] = str_replace('price_id', '', $key);
            }
        }
        if (isset($pos)){
            foreach ($token->tokenPrice as $t)
            $t->delete();
            foreach ($pos as $p){
                $price = new IcoTokenPrice;
                $price->ico_token_id = $token->id;
                $price->start_date = date('Y-m-d H:i:s', strtotime($data['start_date'.$p]));
                $price->end_date = date('Y-m-d H:i:s', strtotime($data['end_date'.$p]));
                $price->bonus = $data['bonus'.$p];
                $price->value = $data['value'.$p];
                $price->nomination = $data['nomination'.$p];
                $price->save();
            }
        }
        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_tokens' => $this->renderPartial('@_tokens.htm',['ico' => $ico])];
    }


    /**
      * Adds token price row to form
      * 
      *
      **/    
    public function onAddTokenPrice(){
        $data = post();
        $keys = array_keys($data);
        $maxid = '0';
        foreach ($keys as $key){
            if (strpos($key, 'price_id') !== false ){
                $pos[] = str_replace('price_id', '', $key);
                $maxid = str_replace('price_id', '', $key);
            }
        }
        if (isset($pos)) {
            foreach ($pos as $p){
                $tokens_prices[$p]['id'] = $p;
                $tokens_prices[$p]['start_date'] = $data['start_date'.$p];
                $tokens_prices[$p]['end_date'] = $data['end_date'.$p];
                $tokens_prices[$p]['bonus'] = $data['bonus'.$p];
                if ($data['value'.$p] = '') 
                    $tokens_prices[$p]['value'] = 0;
                else
                    $tokens_prices[$p]['value'] = $data['value'.$p];
                $tokens_prices[$p]['nomination'] = $data['nomination'.$p];
            }
        }
        $maxid += 1;
        $tokens_prices[$maxid]['id'] = $maxid;
        return ['#_tokenPrice' => $this->renderPartial('@_tokens_price.htm',['tokens_prices' => $tokens_prices])];
    }
    /**
      * Removes token price row from form
      * @var
      * post delete_id // number of deleted line
      *
      * TODO
      *     1. confirmation
      **/    
    public function onDeleteTokenPrice(){
        if (post('delete_id')) {
            $data = post();
            $keys = array_keys($data);
            foreach ($keys as $key){
                if (strpos($key, 'price_id') !== false ){
                    $pos[] = str_replace('price_id', '', $key);
                }
            }
            if (isset($pos)) {
                foreach ($pos as $p){
                    $tokens_prices[$p]['id'] = $p;
                    $tokens_prices[$p]['start_date'] = $data['start_date'.$p];
                    $tokens_prices[$p]['end_date'] = $data['end_date'.$p];
                    $tokens_prices[$p]['bonus'] = $data['bonus'.$p];
                    $tokens_prices[$p]['value'] = $data['value'.$p];
                    $tokens_prices[$p]['nomination'] = $data['nomination'.$p];
                }
            }
            $price = IcoTokenPrice::find(post('delete_id'));
            $price->delete();
            unset($tokens_prices[post('delete_id')]);
            return ['#_tokenPrice' => $this->renderPartial('@_tokens_price.htm',['tokens_prices' => $tokens_prices])];
        }

    }

    /**
      *
      * PUBLICATIONS PART
      * 
      * TODO:
      *   3. confirmation
      */

    public function onAddPublication(){
        if (post('publications_id')){
            $publications = IcoPublications::find(post('publications_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_publications_popup.htm',
                ['title' => 'Edit Publication', 'publications' => $publications
              ])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_publications_popup.htm',['title' => 'Add New Publication'])];
    }

    public function onPublicationSave(){
        if (post('id')) {
            $publications = IcoPublications::find(post('id'));
        } else {
            $publications = new IcoPublications;
            $publications->ico_id = $this->param('id');
        }
        $publications->url = post('url');
        $publications->description = post('description');
        if (post('status') == 'on')
            $publications->status = 1;
        else
            $publications->status = 0;

        if (post('publications-upload')) 
        {
            /* Если меняется лого сохраняем его */
            $content = explode(',',post('publications-upload'));
            $filetype = explode(';', explode('/', $content[0])[1])[0];
            $filename = md5(uniqid(rand(), true)).'.'.$filetype;
            $file = base64_decode($content[1]); 
            Storage::put('media/logo/'.$filename, $file);

            $file = new File;
            $file->data = storage_path('/app/media/logo/'.$filename);
            $file->is_public = true;
            $file->save();

            $publications->image()->add($file);
        }

        $publications->save();
        Flash::success('Publication Was Updated');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_publications' => $this->renderPartial('@_publications.htm',['ico' => $ico])];
    }

    public function onPublicationDelete(){
         if (post('delete_id')) {
            $publications = IcoPublications::find(post('delete_id'));
            $publications->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_publications' => $this->renderPartial('@_publications.htm',['ico' => $ico])];
 
         }
    }

    /**
      * PARTNERS PART
      * OK
      *
      */
    public function onAddPartner(){
        if (post('partners_id')){
            $partners = IcoPartners::find(post('partners_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_partners_popup.htm',
                ['title' => 'Edit Partner', 'partners' => $partners
              ])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_partners_popup.htm',['title' => 'Add New Partner'])];
    }

    public function onPartnerSave(){
        if (post('id')) {
            $partners = IcoPartners::find(post('id'));
        } else {
            $partners = new IcoPartners;
            $partners->ico_id = $this->param('id');
        }
        $partners->name = post('name');
        $partners->url = post('url');
        $partners->description = post('description');
        if (post('status') == 'on')
            $partners->status = 1;
        else
            $partners->status = 0;

        if (post('partners-upload')) 
        {
            /* Если меняется лого сохраняем его */
            $content = explode(',',post('partners-upload'));
            $filetype = explode(';', explode('/', $content[0])[1])[0];
            $filename = md5(uniqid(rand(), true)).'.'.$filetype;
            $file = base64_decode($content[1]); 
            Storage::put('media/logo/'.$filename, $file);

            $file = new File;
            $file->data = storage_path('/app/media/logo/'.$filename);
            $file->is_public = true;
            $file->save();

            $partners->image()->add($file);
        }
        $partners->save();
        Flash::success('Partner Was Updated');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_partners' => $this->renderPartial('@_partners.htm',['ico' => $ico])];
    }
    public function onPartnerDelete(){
         if (post('delete_id')) {
            $partners = IcoPartners::find(post('delete_id'));
            $partners->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_partners' => $this->renderPartial('@_partners.htm',['ico' => $ico])];
 
         }
    }

    /**
      *
      * LOCATIONS PART
      * OK
      */
    public function onAddLocation(){
        if (post('locations_id')){
            $locations = IcoLocation::find(post('locations_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_locations_popup.htm',
                ['title' => 'Edit Location', 'locations' => $locations])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_locations_popup.htm',['title' => 'Add New Location'])];
    }

    public function onLocationSave(){
        if (post('id')) {
            $locations = IcoLocation::find(post('id'));
        } else {
            $locations = new IcoLocation;
            $locations->ico_id = $this->param('id');
        }
      //  $partners->image = post('url');
        $locations->name = post('name');
        $locations->legal = post('legal');
        $locations->address = post('address');
        if (post('status') == 'on')
            $locations->status = 1;
        else
            $locations->status = 0;
        $locations->save();
        Flash::success('Location Was Updated');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_locations' => $this->renderPartial('@_locations.htm',['ico' => $ico])];
    }
    public function onLocationDelete(){
         if (post('delete_id')) {
            $locations = IcoLocation::find(post('delete_id'));
            $locations->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_locations' => $this->renderPartial('@_locations.htm',['ico' => $ico])];
 
         }
    }    
    /**
      *
      * TEAM PART
      * OK
      *
      */
    public function onAddTeamMember(){
        if (post('team_id')){
            $team = Team::find(post('team_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_team_popup.htm',
                ['title' => 'Edit Team Member', 'team' => $team])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_team_popup.htm',['title' => 'Add New Team Member'])];
    }

    public function onTeamSave(){
        if (post('id')) {
            $team = Team::find(post('id'));
        } else {
            $team = new Team;
            $team->ico_id = $this->param('id');
        }
      //  $partners->image = post('url');
        $team->first_name = post('first_name');
        $team->last_name = post('last_name');
        $team->title = post('title');
        $team->type = post('type');
        if (post('status') == 'on')
            $team->status = 1;
        else
            $team->status = 0;
        $team->save();
        Flash::success('Team Member Was Updated');
       
        $data = post();
        $keys = array_keys($data);
        foreach ($keys as $key){
            if (strpos($key, 'link_id') !== false ){
                $pos[] = str_replace('link_id', '', $key);
            }
        }
        if (isset($pos)){
            foreach ($team->links as $t)
            $t->delete();
            foreach ($pos as $p){
                $team_link = new TeamLinks;
                $team_link->team_id = $team->id;
                $team_link->type = $data['type'.$p];
                $team_link->other = $data['other'.$p];
                $team_link->url = $data['url'.$p];
                $team_link->save();
            }
        }
        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_team' => $this->renderPartial('@_team.htm',['ico' => $ico])];
    }
    public function onTeamDelete(){
         if (post('delete_id')) {
            $team = Team::find(post('delete_id'));
            $team->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_team' => $this->renderPartial('@_team.htm',['ico' => $ico])];
 
         }
    }    
    /**
      * TEAM LINKS PART
      * Save function in TEAM PART
      *
      **/    
    public function onAddTeamLink(){
        $data = post();
        $keys = array_keys($data);
        $maxid = '0';
        foreach ($keys as $key){
            if (strpos($key, 'link_id') !== false ){
                $pos[] = str_replace('link_id', '', $key);
                $maxid = str_replace('link_id', '', $key);
            }
        }
        if (isset($pos)) {
            foreach ($pos as $p){
                $team_link[$p]['id'] = $p;
                $team_link[$p]['type'] = $data['type'.$p];
                $team_link[$p]['other'] = $data['other'.$p];
                $team_link[$p]['url'] = $data['url'.$p];
            }
        }
        $maxid += 1;
        $team_link[$maxid]['id'] = $maxid;
        return ['#_teamLink' => $this->renderPartial('@_team_link.htm',['team_link' => $team_link])];
    }

   public function onDeleteTeamLink(){
        if (post('delete_id')) {
            $data = post();
            $keys = array_keys($data);
            foreach ($keys as $key){
                if (strpos($key, 'link_id') !== false ){
                    $pos[] = str_replace('link_id', '', $key);
                }
            }
            if (isset($pos)) {
                foreach ($pos as $p){
                    $team_link[$p]['id'] = $p;
                    $team_link[$p]['type'] = $data['type'.$p];
                    $team_link[$p]['other'] = $data['other'.$p];
                    $team_link[$p]['url'] = $data['url'.$p];
                }
            }
            // здесь проблема при удалении несохраненного
            $team = TeamLinks::find(post('delete_id'));
            if ($team) {
              $team->delete();
              unset($team_link[post('delete_id')]);
              return ['#_teamLink' => $this->renderPartial('@_team_link.htm', ['team_link' => $team_link])];
            }
        }

    }

    /**
      * DATE PART
      * 
      *
      **/    
    public function onAddDate(){
        if (post('dates_id')){
            $dates = IcoDates::find(post('dates_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_dates_popup.htm',
                ['title' => 'Edit Date', 'dates' => $dates
              ])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_dates_popup.htm',['title' => 'Add New Date'])];
    }
 
    public function onDateSave(){
        if (post('id')) {
            $dates = IcoDates::find(post('id'));
        } else {
            $dates = new IcoDates;
            $dates->ico_id = $this->param('id');
        }
      //  $dates->type = post('type');
        if (post('type') == 99)
            $dates->other = post('other');
        else
            $dates->other = '';
        $dates->description = post('description');
        $dates->start_date = date('Y-m-d H:i:s', strtotime(post('start_date')));
        $dates->end_date = date('Y-m-d H:i:s', strtotime(post('end_date')));
        if (post('status') == 'on')
            $dates->status = 1;
        else
            $dates->status = 0;
        
        $dates->save();
        Flash::success('Date Was Updated');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_dates' => $this->renderPartial('@_dates.htm',['ico' => $ico])];
    } 
    public function onDateDelete(){
         if (post('delete_id')) {
            $dates = IcoDates::find(post('delete_id'));
            $dates->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_dates' => $this->renderPartial('@_dates.htm',['ico' => $ico])];
 
         }
    } 
    /**
      * GOAL PART
      * OK
      *
      **/    
    public function onAddGoal(){
        if (post('goals_id')){
            $goals = IcoGoals::find(post('goals_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_goals_popup.htm',
                ['title' => 'Edit Goal', 'goals' => $goals
              ])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_goals_popup.htm',['title' => 'Add New Goal'])];
    }

    public function onGoalSave(){
        if (post('id')) {
            $goals = IcoGoals::find(post('id'));
        } else {
            $goals = new IcoGoals;
            $goals->ico_id = $this->param('id');
        }
        $goals->name = post('name');
        $goals->description = post('description');
        $goals->cap = post('cap');
        $goals->currency = post('currency');
        $goals->reached = post('reached');
        if (post('status') == 'on')
            $goals->status = 1;
        else
            $goals->status = 0;
        if (post('currency') == 99) 
            $goals->other = post('other'); 
        else
            $goals->other = "";
        $goals->save();
        Flash::success('Goal Was Updated');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_goals' => $this->renderPartial('@_goals.htm',['ico' => $ico])];
    }
    public function onGoalDelete(){
         if (post('delete_id')) {
            $team = IcoGoals::find(post('delete_id'));
            $team->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_goals' => $this->renderPartial('@_goals.htm',['ico' => $ico])];
 
         }
    }    
    /**
      * TIMELINE PART
      * 
      *
      **/    

    public function onAddTimeline(){
        if (post('timelines_id')){
            $timelines = IcoTimeline::find(post('timelines_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_timelines_popup.htm',
                ['title' => 'Edit Timeline Point', 'timelines' => $timelines
              ])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_timelines_popup.htm',['title' => 'Add New Timeline Point'])];
    }
    public function onTimelineSave(){
        if (post('id')) {
            $timelines = IcoTimeline::find(post('id'));
        } else {
            $timelines = new IcoTimeline;
            $timelines->ico_id = $this->param('id');
        }
        $timelines->name = post('name');
        $timelines->description = post('description');
        $timelines->start_date = date('Y-m-d H:i:s', strtotime(post('start_date')));
        $timelines->end_date = date('Y-m-d H:i:s', strtotime(post('end_date')));
 
        if (post('status') == 'on')
            $timelines->status = 1;
        else
            $timelines->status = 0;
        
        $timelines->save();
        Flash::success('Timeline Was Updated');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_timelines' => $this->renderPartial('@_timelines.htm',['ico' => $ico])];
    } 


    public function onTimelineDelete(){
         if (post('delete_id')) {
            $timeline = IcoTimeline::find(post('delete_id'));
            $timeline->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_timelines' => $this->renderPartial('@_timelines.htm',['ico' => $ico])];
 
         }
    }    

    /**
      * LINKS PART
      * OK
      *
      **/    
   public function onAddLink(){
        if (post('links_id')){
            $links = IcoLinks::find(post('links_id'));
            return ['#modalPopupBody' => $this->renderPartial('@_links_popup.htm',
                ['title' => 'Edit Link', 'links' => $links
              ])];
        } else
        return ['#modalPopupBody' => $this->renderPartial('@_links_popup.htm',['title' => 'Add New Link'])];
    }
    public function onLinkSave(){
        if (post('id')) {
            $links = IcoLinks::find(post('id'));
        } else {
            $links = new IcoLinks;
            $links->ico_id = $this->param('id');
        }
        $links->type = post('type');
        if (post('type') == 99) 
            $links->other = post('other'); 
        else
            $links->other = "";
        $links->url = post('url');
        $links->description = post('description');
        if (post('status') == 'on')
            $links->status = 1;
        else
            $links->status = 0;
        
        $links->save();
        Flash::success('Link Was Updated');

        $user = Auth::getUser();
        $ico = $user->ico->where('id','=',$this->param('id'))->first();  
        return ['#_links' => $this->renderPartial('@_links.htm',['ico' => $ico])];
    }
    public function onLinkDelete(){
         if (post('delete_id')) {
            $links = IcoLinks::find(post('delete_id'));
            $links->delete();
            
            $user = Auth::getUser();
            $ico = $user->ico->where('id','=',$this->param('id'))->first();  
            return ['#_links' => $this->renderPartial('@_links.htm',['ico' => $ico])];
 
         }
    }    }    


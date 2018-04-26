<?php 

namespace Smart2be\IcoAdvice\Components;
use Cms\Classes\ComponentBase;
use Smart2be\IcoAdvice\Controllers\Ico as IcoController;
use \Smart2be\IcoAdvice\Models\Ico;
use Log;
use Auth;
use Input;

class Icos extends ComponentBase
{
  public function componentDetails()
  {
      return [
          'name' => 'Ico Create Form',
          'description' => 'Backend form used in the front-end'
      ];
  }

  public function onSave()
  {
    
    Log::info('Showing user profile for user: '.Input::all());

/*    $result = \Smart2be\IcoAdvice\Models\Ico::create(post('icoForm'));

    Ico::find($result->id);
    $back = Ico::find($result->id);
    $back->users = [['ico_id' => $result->id, 'user_id' => Auth::getUser()->id]];
    $back->save(); */



    return ['#result' => post('IcoForm')];// ['error' => \Smart2be\IcoAdvice\Models\Ico::create($result)];
  }




}
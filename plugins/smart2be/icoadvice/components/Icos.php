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

    

    public function onRun(){
        $this->addJs('assets/js/uploader.js');
    }

    public function componentDetails()
    {
        return [
            'name' => 'Ico Create Form',
            'description' => 'Backend form used in the front-end'
        ];
    }

    public function onSave()
    {
        // Доработать лог-файл
        Log::info('Showing user profile for user: '.implode(Input::all()));


        if (post('file-upload')){
            $content = explode(',',post('file-upload'));
            $filetype = explode(';', explode('/', $content[0])[1])[0];
            $filename = md5(uniqid(rand(), true)).'.'.$filetype;
            $file = base64_decode($content[1]); 
            Storage::put('media/logo/'.$filename, $file);



            $file = new File;
            $file->data = storage_path('/app/media/logo/'.$filename);
            $file->is_public = true;
            $file->save();
        }

       
        // Сохранение ICO и соответствующего юзера
        $user = Auth::getUser();
        $ico = Ico::create(['name' => post('name'), 'tiker' => post('name')]);
        $ico->users = [$user];
        if (post('file-upload')) $ico->logo()->add($file);
        $ico->save();
        Log::info('New ICO record created');
        Log::info('ICO Name: '.post('name').', id: '.$ico->id);
        Log::info('user: '.$user->name.', id: '.$user->id.', email: '.$user->email);
        Log::info('logo path: '.$ico->logo);

        return Redirect::to('dashboard');
    }




}
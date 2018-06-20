<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class IcoPartners extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|string|max:50',
        'url' => 'nullable|url',
        'description' => 'required|string|max:1000',
        'status' => 'digits_between:0,1'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_partners';

    public $attachOne = [
        'image' => ['System\Models\File'],
    ];
}

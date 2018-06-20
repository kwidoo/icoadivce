<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class IcoContacts extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'status' => 'required|digits_between:0,1',
        'value' => 'required|string',
        'type' => 'required|digits_between:0,99',
        'other' => 'required_if:type,99|string',
        'description' => 'nullable|string'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_contacts';

}

<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class IcoGoals extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|string',
        'description' => 'nullable|max:1000',
        'cap' => 'required',
        'currency' =>'required|digits_between:0,99',    // 99 - всегда Other
        'other' => 'required_if:currency,99|string',
        'reached' => 'required|digits_between:0,2',
        'status' => 'digits_between:0,1'      // 
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_goals';


    public $attachOne = [
        'image' => ['System\Models\File'],
    ];
}

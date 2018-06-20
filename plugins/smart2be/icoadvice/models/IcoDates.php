<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class IcoDates extends Model
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
        'description' => 'nullable|string|max:1000',
        'start_date' => 'required_if:end_date,null|date',
        'end_date' => 'required_if:start_date,null|date|after_or_equal:start_date',
        'status' => 'required|digits_between:0,1',  
        'type' => 'required|digits_between:0,99',
        'other' => 'required_if:type,99' 
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_dates';
}
 
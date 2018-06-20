<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class IcoTokenPrice extends Model
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
        'start_date' => 'required_if:end_date,null|date',
        'end_date' => 'required_if:start_date,null|date|after_or_equal:start_date',
        'bonus' => 'required|digits_between:0,2',  
        'value' => 'required',
        'nomination' => 'required|digits_between:0,99',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_token_price';

    public function getStartDate()
    {
        // should be able to parse this format: Mar 2 2014 12:00:00:000AM
        return \DateTime::createFromFormat("M j Y h:i:s:uA", $this->start_date);
    }    
    public function getEndDate()
    {
        // should be able to parse this format: Mar 2 2014 12:00:00:000AM
        return \DateTime::createFromFormat("M j Y h:i:s:uA", $this->start_date);
    }
}

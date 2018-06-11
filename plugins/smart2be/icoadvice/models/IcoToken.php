<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class IcoToken extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [ 
        'name' => 'required|string',
        'type' => 'required|digits_between:0,99', 
        'other' => 'required_if:type,99|string',
        'decimal' => 'required',
        'tracker' => 'nullable|url',
    ];

 /*   public $messages = [
        'name.required' => 'You should enter your token\'s name',
        'name.string' => 'Token\'s name must be a string',
        'decimal.required' => 'You must specify token\'s decimal',
        'tracker.url' => 'Token Tracker should be a valid url, including http or https',
        'other.required_if' => 'You must specify token\'s type',
        'other.string' => 'Token\'s type must be a string'
    ]; */

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_token';

    public $hasMany = ['tokenPrice' => 'Smart2be\IcoAdvice\Models\IcoTokenPrice'];


}

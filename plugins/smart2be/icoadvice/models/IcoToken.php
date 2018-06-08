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
        'name' => 'required|alpha_dash',
        'decimal' => 'required',
        'tracker' => 'nullable|url',
        'type' => 'required|digits_between:0,5'       
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_token';

    public $hasMany = ['tokenPrice' => 'Smart2be\IcoAdvice\Models\IcoTokenPrice'];


}

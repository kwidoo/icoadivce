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
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_token_price';
}

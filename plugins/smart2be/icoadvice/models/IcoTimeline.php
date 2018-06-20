<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class IcoTimeline extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string|max:1000',
        'start_date' => 'required_if:end_date,null|date',
        'end_date' => 'required_if:start_date,null|date|after_or_equal:start_date',
        'status' => 'required|digits_between:0,1',


    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico_timeline';

    public $attachOne = [
        'image' => ['System\Models\File'],
    ];
}

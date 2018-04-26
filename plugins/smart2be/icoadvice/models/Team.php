<?php namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class Team extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_team';

    public $hasMany = [
        'links' => ['Smart2be\IcoAdvice\Models\TeamLinks', 'key' => 'team_id'],
        'contacts' => ['Smart2be\IcoAdvice\Models\TeamContacts', 'key' => 'team_id'],
        'contacts' => ['Smart2be\IcoAdvice\Models\TeamDocuments', 'key' => 'team_id']
    ];

    public $attachOne = [
        'photo' => ['System\Models\File'],
    ];
}

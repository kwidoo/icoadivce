<?php 
namespace Smart2be\IcoAdvice\Models;

use Model;

/**
 * Model
 */
class Ico extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'tiker'];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico';

    public $belongsToMany = [
        'users' => ['RainLab\User\Models\User', 'table' => 'smart2be_icoadvice_ico_user']
    ];

    public $hasMany = [
        'members' => 'Smart2be\IcoAdvice\Models\Team',
        'partners' => 'Smart2be\IcoAdvice\Models\IcoPartners',
        'publications' => 'Smart2be\IcoAdvice\Models\IcoPublications',
        'dates' => 'Smart2be\IcoAdvice\Models\IcoDates',
        'goals' => 'Smart2be\IcoAdvice\Models\IcoGoals',
        'locations' => 'Smart2be\IcoAdvice\Models\IcoLocation',
        'timelines' => 'Smart2be\IcoAdvice\Models\IcoTimeline'    
    ];

    public $hasOne = [
        'token' => 'Smart2be\IcoAdvice\Models\IcoToken',
    ];
    public $belongsTo = [
         'category' => 'Smart2be\IcoAdvice\Models\IcoCategory',
   ];

    public $attachOne = [
        'logo' => ['System\Models\File'],
    ];
}

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
        'name' => 'required|string',
        'tiker' => 'required|string|max:20',
        'start_date' => 'required:update|date',
        'end_date' => 'required_if:start_date,null|date|after_or_equal:start_date',
        'cap_nomination' => 'required:update|digits_between:0,99',
        'other' => 'required_if:cap_nomination,99',
        'soft_cap' => 'nullable|string',
        'hard_cap' => 'nullable|string',
        'slogan' => 'nullable|string',
        'short' => 'nullable|string',
        'description' => 'nullable|string'

    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'smart2be_icoadvice_ico';

    public $belongsToMany = [
        'users' => ['RainLab\User\Models\User',  'foreignkey' => 'id']
    ];
    public $belongsToOne = [
        'category' => 'Smart2be\IcoAdvice\Models\IcoCategory'
    ];

    public $hasMany = [
        'links' => 'Smart2be\IcoAdvice\Models\IcoLinks',
        'contacts' => 'Smart2be\IcoAdvice\Models\IcoContacts',
        'team' => 'Smart2be\IcoAdvice\Models\Team',
        'partners' => 'Smart2be\IcoAdvice\Models\IcoPartners',
        'publications' => 'Smart2be\IcoAdvice\Models\IcoPublications',
        'dates' => 'Smart2be\IcoAdvice\Models\IcoDates',
        'goals' => 'Smart2be\IcoAdvice\Models\IcoGoals',
        'locations' => 'Smart2be\IcoAdvice\Models\IcoLocation',
        'timeline' => 'Smart2be\IcoAdvice\Models\IcoTimeline',
        'tokens' => 'Smart2be\IcoAdvice\Models\IcoToken',

    ];

    public $attachOne = [
        'logo' => ['System\Models\File'],
    ];
}

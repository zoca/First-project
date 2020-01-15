<?php

/**
 * Class
 *
 * PHP version 7.2
 */
namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

use App\Models\Utils\{
    ActiveInactiveInterface,
    ActiveInactiveTrait,
    CropImageMultiTrait,
    CropImageSingleTrait,
    CropImageTrait,
    FileableTrait
};

/**
 * Example Model for describing standards
 */
class FormType extends Model 
{
    
    use SoftDeletes, FileableTrait;
    
    /**
     * specifying table names is recommended
     */
    protected $table = 'form_types';
    
    /**
     * used to check which columns may be updated using mass-assignment
     */
    protected $fillable = ['name', 'created_by'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name'];
    
    /**
     * used to fetch certain attributes as Date objects
     */
    protected $dates = ['created_at', 'updated_at'];
    
    /**
     * https://laravel.com/docs/5.5/eloquent-mutators#attribute-casting
     */
    // protected $casts = ['data' => 'array'];
    
    /**
     * https://laravel.com/docs/5.5/eloquent-relationships#touching-parent-timestamps
     */
    // protected $touches = ['exampleParent'];
        
    
    /**
     * Relationships: must be declared for all related models, even if they will never be used
     */
    public function fields()
    {
        return $this->belongsToMany(FormField::class, 'type_form_field', 'form_type_id', 'form_field_id');
    }
    /**
     * Local Scopes: must be declared to avoid code repetition when querying the entity against its own table or any related table
     *
     * @param mixed $query
     */
    public function scopeMy($query)
    {
        return $query->where('created_by', auth()->user()->id);
    }
}

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
class DynamicForm extends Model 
{
    use FileableTrait, SoftDeletes;
    use \App\Models\Utils\ImageableTrait;
    
    /**
     * specifying table names is recommended
     */
    protected $table = 'dynamic_forms';
    
    /**
     * used to check which columns may be updated using mass-assignment
     */
    protected $fillable = ['form_id', 'title', 'seo_title', 'description','seo_description','car_condition','equipments','fuel','photo','created_by'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['form_id', 'title', 'seo_title', 'description','seo_description','car_condition','equipments','fuel','photo'];
    
    /**
     * used to fetch certain attributes as Date objects
     */
    protected $dates = ['created_at', 'updated_at'];
    
  
    /**
     * Relationships: must be declared for all related models, even if they will never be used
     */
    
        
    /**
     * Local Scopes: must be declared to avoid code repetition when querying the entity against its own table or any related table
     *
     * @param mixed $query
     */
    public function scopeMy($query)
    {
        return $query->where('created_by', auth()->user()->id);
    }
    
    /**
     * Overriding delete method if delete logic is complicated & is a HARD delete.
     *
     * DO NOT DO THIS IF SOFT DELETE!!!
     */
    public function delete()
    {
        // deleting many-to-many relationships
        // $this->tags()->sync([]);
        // delete children if needed
        //$this->exampleChildren()->delete();
        // delete all related files by columns
        $this->deleteFile('photo');
        // delete this instance
        return parent::delete();
    }
}

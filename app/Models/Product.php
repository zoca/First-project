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
class Product extends Model implements ActiveInactiveInterface
{
    use ActiveInactiveTrait, FileableTrait, SoftDeletes;
    
    /**
     * specifying table names is recommended
     */
    protected $table = 'products';
    
    /**
     * used to check which columns may be updated using mass-assignment
     */
    protected $fillable = ['name', 'price', 'sku', 'primary_category_id', 'description', 'active', 'created_by'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['active', 'name', 'description', 'primary_category_id', 'price', 'sku'];
    
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
    
    public function primaryCategory()
    {
        return $this->belongsTo(Category::class, 'primary_category_id');
    }
    

    public function otherCategories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
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

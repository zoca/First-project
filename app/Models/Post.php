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

use App\Models\Comment;
use App\Models\Tag;

/**
 * Example Model for describing standards
 */
class Post extends Model implements ActiveInactiveInterface
{
    use ActiveInactiveTrait, SoftDeletes;
    
    /**
     * Constants: must be declared for non-arbitrary values, that will always correspond to an attribute in Entity
     */
    const STATUSES = [
        'status1',
        'status2',
        'status3',
        'status4',
    ];
    
    const STATUS_1 = 'status1';
    const STATUS_2 = 'status2';
    const STATUS_3 = 'status3';
    const STATUS_4 = 'status4';
    
    /**
     * specifying table names is recommended
     */
    protected $table = 'posts';
    
    /**
     * used to check which columns may be updated using mass-assignment
     */
    protected $fillable = ['title', 'description', 'active', 'status', 'created_by', 'order_number'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['active', 'status', 'title', 'description', 'order_number'];
    
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
       

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_post', 'post_id', 'tag_id');
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
        $this->tags()->sync([]);
        // delete children if needed
        //$this->exampleChildren()->delete();
        // delete all related files by columns
        $this->comments()->delete();
        // delete this instance
       
    }
}

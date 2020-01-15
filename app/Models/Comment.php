<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

use App\Models\Post;

class Comment extends Model
{
    // use SoftDeletes;

      /**
     * used to check which columns may be updated using mass-assignment
     */
    protected $fillable = ['text', 'post_id', 'created_by'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

}

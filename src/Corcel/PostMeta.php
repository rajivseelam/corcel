<?php 

/**
 * Corcel\PostMeta
 * 
 * @author Junior Grossi <me@juniorgrossi.com>
 */

namespace Corcel;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PostMeta extends Eloquent
{
    protected $table = 'wp_postmeta';
    protected $primaryKey = 'meta_id';

    /**
     * Post relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Corcel\Post');
    }

    /**
     * Override newCollection() to return a custom collection
     * 
     * @param array $models
     * @return \Corcel\PostMetaCollection
     */
    public function newCollection(array $models = array())
    {
        return new PostMetaCollection($models);
    }
}
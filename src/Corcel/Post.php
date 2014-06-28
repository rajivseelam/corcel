<?php 

/**
 * Post model
 * 
 * @author Junior Grossi <me@juniorgrossi.com>
 */

namespace Corcel;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $table = 'wp_posts';
    protected $primaryKey = 'ID';
    protected $with = array('meta', 'comments', 'postterms');
    protected $postType = 'post';


    /**
     * Get only those posts which has manually filled excerpts
     * 
     * @param  [type] $query [description]
     * @return Query
     */
    public function scopeExcerpt($query)
    {
        return $query->where('post_excerpt', '<>', '');
    }

    /**
     * Meta data relationship
     * 
     * @return Corcel\PostMetaCollection
     */
    public function meta()
    {
        return $this->hasMany('Corcel\PostMeta', 'post_id');
    }

    /**
     * Get thumbnail url
     * @param  string $size 'thumbnail','medium','large'
     * @return String
     */
    public function thumbnail_url($size='thumbnail')
    {
        return (is_array($src_array = wp_get_attachment_image_src($this->meta->_thumbnail_id, $size))) ?
            $src_array[0] : '';
    }

    /**
     * Comments relationship
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function comments()
    {
        return $this->hasMany('Corcel\Comment', 'comment_post_ID');
    }

    /**
     * TermRelationship relationship
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function postterms()
    {
        return $this->hasMany('Corcel\TermRelationship','object_id','ID');
    }

    /**
     * Tags for this post
     *
     * @return Illuminate\Database\Eloquent\Collection
     **/
    public function tags()
    {
        $new = $this->postterms->filter(function($term)
                {
                    return $term->termtaxonomy->taxonomy == 'post_tag';
                });

        return  $new->map(function($term)
                {
                    return $term->termtaxonomy->term; 
                });
    }


    /**
     * Categories for this post
     *
     * @return Illuminate\Database\Eloquent\Collection
     **/
    public function categories()
    {
        $new = $this->postterms->filter(function($term)
                {
                    return $term->termtaxonomy->taxonomy == 'category';
                });

        return  $new->map(function($term)
                {
                    return $term->termtaxonomy->term; 
                });
    }
    

    /**
     * Overriding newQuery() to the custom PostBuilder with some intereting methods
     * 
     * @param bool $excludeDeleted
     * @return Corcel\PostBuilder
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new PostBuilder($this->newBaseQueryBuilder());
        $builder->setModel($this)->with($this->with);
        $builder->orderBy('post_date', 'desc');

        if (isset($this->postType) and $this->postType) {
            $builder->type($this->postType);
        }

        if ($excludeDeleted and $this->softDelete) {
            $builder->whereNull($this->getQualifiedDeletedAtColumn());
        }

        return $builder;
    }

    /**
     * Magic method to return the meta data like the post original fields
     * 
     * @param string $key
     * @return string
     */
    public function __get($key)
    {
        if (!isset($this->$key)) {
            return $this->meta->$key;    
        }

        return parent::__get($key);
    }

}
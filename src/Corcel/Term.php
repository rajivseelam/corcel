<?php 

/**
 * Corcel\Comment
 * 
 * @author Junior Grossi <me@juniorgrossi.com>
 */

namespace Corcel;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Term extends Eloquent
{
    protected $table = 'wp_terms';
    protected $primaryKey = 'term_id';

    /**
     * Get TermTaxonomy relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
    	return $this->belongsTo('Corcel\TermTaxonomy','term_id','term_id');
    }

    /**
     * Term relationship
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * 
     **/
    public function termrelationships()
    {
        return $this->hasManyThrough('Corcel\TermRelationship','Corcel\TermTaxonomy');
    }

    /**
     * Get posts under a term
     *
     * @return Corcel\Post
     * 
     **/
    public function posts()
    {
        return $this->termrelationships->map(function($relationship)
                {
                   return $relationship->post; 
                });
    }
}

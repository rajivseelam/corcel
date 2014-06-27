<?php 

/**
 * Corcel\Comment
 * 
 * @author Junior Grossi <me@juniorgrossi.com>
 */

namespace Corcel;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TermRelationship extends Eloquent
{
    protected $table = 'wp_term_relationships';
    protected $primaryKey = 'term_taxonomy_id';

    /**
     * Post relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Corcel\Post','object_id','ID');
    }

    /**
     * TermTaxonomy relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function termtaxonomy()
    {
        return $this->hasOne('Corcel\TermTaxonomy','term_taxonomy_id','term_taxonomy_id');
    }

}

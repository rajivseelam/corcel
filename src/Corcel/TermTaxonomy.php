<?php 

/**
 * Corcel\Comment
 * 
 * @author Junior Grossi <me@juniorgrossi.com>
 */

namespace Corcel;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TermTaxonomy extends Eloquent
{
    protected $table = 'wp_term_taxonomy';
    protected $primaryKey = 'term_id';

    /**
     * Get the Term relationship
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function term()
    {
    	return $this->hasOne('Corcel\Term','term_id','term_id');
    }

    /**
    * Get TermRelationship relationship
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function relationships()
    {
    	return $this->hasMany('Corcel\TermRelationship','term_taxonomy_id','term_taxonomy_id');
    }
}

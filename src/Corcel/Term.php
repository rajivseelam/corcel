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

}

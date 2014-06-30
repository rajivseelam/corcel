<?php 

/**
 * Corcel\Comment
 * 
 * @author Junior Grossi <me@juniorgrossi.com>
 */

namespace Corcel;

use Illuminate\Database\Eloquent\Builder as Builder;

class Category extends Term
{

    /**
     * Overriding newQuery() to the custom PostBuilder with some intereting methods
     * 
     * @param bool $excludeDeleted
     * @return Corcel\PostBuilder
     */
    public function newQuery($excludeDeleted = true)
    {
        $builder = new Builder($this->newBaseQueryBuilder());
        $builder->setModel($this);

        $builder
        ->leftJoin('wp_term_taxonomy','wp_terms.term_id','=','wp_term_taxonomy.term_id')
        ->where('wp_term_taxonomy.taxonomy','=','category');

        if ($excludeDeleted and $this->softDelete) {
            $builder->whereNull($this->getQualifiedDeletedAtColumn());
        }

        return $builder;
    }

}

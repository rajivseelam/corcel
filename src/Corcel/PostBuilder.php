<?php 

/**
 * Corcel\PostBuilder
 * 
 * @author Junior Grossi <me@juniorgrossi.com>
 */

namespace Corcel;

use Illuminate\Database\Eloquent\Builder;

class PostBuilder extends Builder
{
    /**
     * Get only posts with a custom status
     * 
     * @param string $postStatus
     * @return \Corcel\PostBuilder
     */
    public function status($postStatus)
    {
        return $this->where('post_status', $postStatus);
    }

    /**
     * Get only published posts
     * 
     * @return \Corcel\PostBuilder
     */
    public function published()
    {
        return $this->status('publish');
    }

    /**
     * Get only posts from a custo post type
     * 
     * @param string $type
     * @return \Corcel\PostBuilder
     */
    public function type($type)
    {
        return $this->where('post_type', $type);
    }

    /**
     * Get only posts with a specific slug
     * 
     * @param string slug
     * @return \Corcel\PostBuilder
     */
    public function slug($slug)
    {
        return $this->where('post_name', $slug);
    }

    /**
     * Overrides the paginate() method to a custom and simple way.
     * 
     * @param int $perPage
     * @param int $currentPage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function paginate($perPage = 10, $currentPage = 1)
    {
        $skip = $currentPage * $perPage - $perPage;
        return $this->skip($skip)->take($perPage)->get();
    }
}

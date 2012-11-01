<?php

namespace Openair\Api\Project;

/**
 * Searching users, getting user information
 *
 */
class Task extends AbstractApi
{
    /**
     * Search users by username:
     *
     * @param  string $keyword the keyword to search
     * @return array list of users found
     */
    public function find($keyword)
    {
        return $this->get('legacy/user/search/'.urlencode($keyword));
    }
}

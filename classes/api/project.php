<?php

namespace Openair\Api;

use Openair\Api\Abstract_Api,
Openair\Api\Project;


class Project extends Abstract_Api
{
    protected $_node_name = 'Project';


    /**
     * Work with the project tasks
     *
     * @param void
     * @return Openair\Api\Project\Task
     */
    public function task()
    {
        return new Project\Task( $this->client );
    }

    /**
     * Work with the project stages
     *
     * @param void
     * @return Openair\Api\Project\Stage
     */
    public function stage()
    {
        return new Project\Stage( $this->client );
    }

    /**
     * Work with the project task types
     *
     * @param void
     * @return Openair\Api\Project\Task\Type
     */
    public function task_type()
    {
        return new Project\Task\Type( $this->client );
    }

}

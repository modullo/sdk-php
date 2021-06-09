<?php

namespace Hostville\Modullo\Services\Courses;


use Hostville\Modullo\Services\AbstractService;

class Course extends AbstractService
{
    /**
     * @inheritdoc
     */
    public function requiresAuthorization(): bool
    {
        return true;
    }

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    function getName(): string
    {
        return 'Course';
    }
}
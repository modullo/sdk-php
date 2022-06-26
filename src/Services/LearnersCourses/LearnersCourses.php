<?php

namespace Hostville\Modullo\Services\LearnersCourses;


use Hostville\Modullo\Services\AbstractService;

class LearnersCourses extends AbstractService
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
        return 'LearnersCourses';
    }
}
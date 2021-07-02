<?php

namespace Hostville\Modullo\Services\Learner\Lessons;


use Hostville\Modullo\Services\AbstractService;

class LearnerLesson extends AbstractService
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
        return 'LearnerLesson';
    }
}
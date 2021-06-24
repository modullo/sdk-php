<?php

namespace Hostville\Modullo\Services\Learner\Programs;


use Hostville\Modullo\Services\AbstractService;

class LearnerProgram extends AbstractService
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
        return 'LearnerProgram';
    }
}
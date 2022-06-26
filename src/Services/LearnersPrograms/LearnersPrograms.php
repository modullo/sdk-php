<?php

namespace Hostville\Modullo\Services\LearnersPrograms;


use Hostville\Modullo\Services\AbstractService;

class LearnersPrograms extends AbstractService
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
        return 'LearnersPrograms';
    }
}
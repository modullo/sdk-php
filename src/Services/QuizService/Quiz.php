<?php

namespace Hostville\Modullo\Services\QuizService;


use Hostville\Modullo\Services\AbstractService;

class Quiz extends AbstractService
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
        return 'Quiz';
    }
}
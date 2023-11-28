<?php

declare(strict_types=1);

namespace Application\GetUser;

use Application\AbstractInputModel;

final class InputModel extends AbstractInputModel
{
    /**
     * @param mixed[] $data
     */
    public function throwExceptionOnFailure(array $data): void
    {
        //
    }
}

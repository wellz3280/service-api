<?php

declare(strict_types=1);

namespace Application\CreateUser;

use Application\AbstractInputModel;
use Domain\ValueObjects\Email;

final class InputModel extends AbstractInputModel
{
    public function getName(): string
    {
        return $this->payload['name'];
    }

    public function getEmail(): Email
    {
        return Email::create($this->payload['email']);
    }

    public function throwExceptionOnFailure($data): void
    {
        //
    }
}

<?php

declare(strict_types=1);

namespace Application\CreateUser;

use Application\AbstractInputModel;
use Domain\ValueObjects\Email;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

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
        try {
            v::key('name', v::stringType()->notEmpty()->setName('name'))
            ->assert($data['payload']);
        } catch(NestedValidationException $exception) {
           echo $exception->getFullMessage();
        }
    }
}

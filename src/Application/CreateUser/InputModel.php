<?php

declare(strict_types=1);

namespace Application\CreateUser;

use Application\AbstractInputModel;
use Domain\Exceptions\ValidationException;
use Domain\ValueObjects\Email;
use Domain\ValueObjects\Password;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

final class InputModel extends AbstractInputModel
{
    public function getPassword(): Password
    {
        return Password::create($this->getPayload()['password']);
    }

    public function getName(): string
    {
        return $this->payload['name'];
    }

    public function getEmail(): Email
    {
        return Email::create($this->payload['email']);
    }

    /**
     * @param mixed[] $data
     */
    public function throwExceptionOnFailure(array $data): void
    {
        try {
            v::key('name', v::stringType()->notEmpty()->setName('name'))
                ->key('password', v::stringType()->notEmpty())
            ->assert($data['payload']);
        } catch (NestedValidationException $exception) {
            throw ValidationException::create($exception->getMessages([
                'password' => 'password must be present.',
            ]));
        }
    }
}

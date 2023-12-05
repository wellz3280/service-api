<?php

declare(strict_types=1);

namespace Application\DeleteUser;

use Application\AbstractInputModel;
use Domain\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

final class InputModel extends AbstractInputModel
{
    public function getId(): int
    {
        return (int) $this->getPayload()['id'];
    }

    /**
     * @param mixed[] $data
     */
    public function throwExceptionOnFailure(array $data): void
    {
        try {
            v::key('id', v::numericVal()->setName('id'))
            ->assert($data['payload']);
        } catch (NestedValidationException $exception) {
            throw ValidationException::create($exception->getMessages([
                'id' => 'id must be type integer',
            ]));
        }
    }
}

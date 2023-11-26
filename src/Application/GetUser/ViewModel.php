<?php

declare(strict_types=1);

namespace Application\GetUser;

use Application\AbstractViewModel;
use JsonSerializable;

final class ViewModel extends AbstractViewModel implements JsonSerializable
{
   public readonly array $users;

   public function __construct(array $users)
   {
      $this->users = $users;
   }

   public static function createFromArray(?array $data = null): self
   {
      return new self($data ?? []);
   }

   public function toArray(): array
   {
      return $this->users;
   }

   public function jsonSerialize(): mixed
   {
      return $this->formatter($this->toArray());
   }

   private function formatter(array $payload): array
   {
      return ['data' => $payload];
   }
}

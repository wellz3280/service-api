<?php

declare(strict_types=1);

namespace Application;

abstract class AbstractInputModel implements InputModelInterface
{
    protected array $payload;

    protected array $filter;

    protected array $paginate;

    abstract function throwExceptionOnFailure($data): void;

    /**
     * @param mixed[] $payload
     * @param mixed[] $filter
     * @param mixed[] $paginate
     */
    public function __construct(array $payload, array $filter, array $paginate)
    {
        $data = [
            'payload'   => $payload,
            'filter'    => $filter,
            'paginate' => $paginate,
        ];

        $this->throwExceptionOnFailure($data);

        $this->payload  = $payload;
        $this->filter   = $filter;
        $this->paginate = $paginate;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getFilter(): array
    {
        return $this->filter;
    }

    public function getPaginate(): array
    {
        return $this->paginate;
    }

    public static function createFromArray(array $data): self
    {
        return new static(
            $data['payload'] ?? [],
            $data['filter'] ?? [],
            $data['paginate'] ?? []
        );
    }
}

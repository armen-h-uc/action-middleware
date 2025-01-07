<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Entities;

use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Stringable;

use function json_encode;

/**
 * Base Entity class.
 *
 * @package App\Aggregates\Entities
 */
abstract class Entity implements Jsonable, JsonSerializable, Stringable
{
    /**
     * Entity identifier.
     *
     * @var int|string|null
     */
    protected int|string|null $id;

    /**
     * @param int|string|null $id
     *
     * @return static
     */
    public function setId(int|string|null $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getId(): int|string|null
    {
        return $this->id;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}

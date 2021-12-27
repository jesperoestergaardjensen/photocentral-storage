<?php

namespace PhotoCentralStorage;

class PhotoCollection
{
    public const ARRAY_KEY_ID = 'id';
    public const ARRAY_KEY_NAME = 'name';
    public const ARRAY_KEY_DESCRIPTION = 'description';
    public const ARRAY_KEY_ENABLED = 'enabled';
    public const ARRAY_KEY_LAST_UPDATED = 'last_updated';

    private string $id;
    private string $name;
    private ?string $description;
    private bool $enabled;
    private ?int $last_updated;

    public function __construct(string $id, string $name, bool $enabled, ?string $description, ?int $last_updated)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->enabled = $enabled;
        $this->last_updated = $last_updated;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function toArray(): array
    {
        return [
            self::ARRAY_KEY_ID => $this->id,
            self::ARRAY_KEY_NAME => $this->name,
            self::ARRAY_KEY_DESCRIPTION => $this->description,
            self::ARRAY_KEY_ENABLED => $this->enabled,
            self::ARRAY_KEY_LAST_UPDATED => $this->last_updated
        ];
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array[self::ARRAY_KEY_ID],
            $array[self::ARRAY_KEY_NAME],
            $array[self::ARRAY_KEY_ENABLED],
            $array[self::ARRAY_KEY_DESCRIPTION],
            $array[self::ARRAY_KEY_LAST_UPDATED],
        );
    }

    /**
     * @return int|null
     */
    public function getLastUpdated(): ?int
    {
        return $this->last_updated;
    }

    /**
     * @param int|null $last_updated
     */
    public function setLastUpdated(?int $last_updated): void
    {
        $this->last_updated = $last_updated;
    }
}

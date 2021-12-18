<?php

namespace PhotoCentralStorage;

class PhotoCollection
{
    private string $id;

    private string $name;

    private ?string $description;

    private bool $enabled;

    public function __construct(string $id, string $name, ?string $description, bool $enabled)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->enabled = $enabled;
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
}

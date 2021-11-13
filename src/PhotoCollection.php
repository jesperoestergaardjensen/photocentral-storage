<?php

namespace PhotoCentralStorage;

class PhotoCollection
{
    private string $id;

    private string $name;

    private ?string $description;

    /**
     * @var Photo[] $photo_list
     */
    private array $photo_list;

    public function __construct(string $id, string $name, ?string $description, array $photo_list = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->photo_list = $photo_list;
    }

    /**
     * @param Photo[] $photo_list
     */
    public function setPhotoList(array $photo_list): void
    {
        $this->photo_list = $photo_list;
    }

    /**
     * @return Photo[]
     */
    public function getPhotoList(): array
    {
        return $this->photo_list;
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
}

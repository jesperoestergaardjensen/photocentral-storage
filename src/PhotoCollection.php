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
}
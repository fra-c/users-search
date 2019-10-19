<?php

namespace UsersSearch;

class User implements \JsonSerializable
{
    /** @var string */
    private $id;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    private function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function named(string $firstName, string $lastName)
    {
        return new static($firstName, $lastName);
    }

    public function jsonSerialize()
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        ];
    }
}

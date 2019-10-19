<?php

namespace UsersSearch;

use ArrayIterator;
use JsonSerializable;

class UserCollection extends ArrayIterator implements JsonSerializable
{
    public function add(User $user) {
        $this->append($user);
    }

    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}

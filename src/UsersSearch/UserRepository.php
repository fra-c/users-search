<?php

namespace UsersSearch;

interface UserRepository
{
    public function findByTerms(string $terms, bool $filterDuplicates = false): UserCollection;
}

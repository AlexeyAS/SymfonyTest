<?php

namespace App\Entity\Filter;


use App\Entity\User;
use App\Services\Filters\BaseSearch;
use App\Services\Filters\Searchable;

class UserSearch implements Searchable
{
    const MODEL = User::class;
    use BaseSearch;
}
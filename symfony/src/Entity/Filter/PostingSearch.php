<?php

namespace App\Entity\Filter;


use App\Entity\Posting;
use App\Services\Filters\BaseSearch;
use App\Services\Filters\Searchable;

class PostingSearch implements Searchable
{
    const MODEL = Posting::class;
    use BaseSearch;
}
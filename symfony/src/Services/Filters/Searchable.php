<?php

namespace App\Services\Filters;

use Symfony\Component\HttpFoundation\Request;

interface Searchable
{
    public function apply(Request $request);

}
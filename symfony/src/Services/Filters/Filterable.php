<?php

namespace App\Services\Filters;

use Symfony\Component\Form\FormBuilderInterface;

interface Filterable
{
    public static function apply(FormBuilderInterface $builder, $value);

}
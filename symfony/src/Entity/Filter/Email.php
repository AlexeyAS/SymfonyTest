<?php

namespace App\Entity\Filter;


use App\Services\Filters\Filterable;
use Symfony\Component\Form\FormBuilderInterface;

//фильтр имэйла, точные совпадения
class Email implements Filterable
{
    public static function apply(FormBuilderInterface $builder, $value)
    {
        return $builder->where('email', $value);
    }

}
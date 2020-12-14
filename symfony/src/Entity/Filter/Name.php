<?php

namespace App\Entity\Filter;


use App\Services\Filters\Filterable;
use Symfony\Component\Form\FormBuilderInterface;

//фильтр имени пользователя, неточные совпадения
class Name implements Filterable
{
    public static function apply(FormBuilderInterface $builder, $value)
    {
        return $builder->where('name', 'LIKE','%'.$value.'%');
    }

}
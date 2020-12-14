<?php

namespace App\Entity\Filter;


use App\Services\Filters\Filterable;
use Symfony\Component\Form\FormBuilderInterface;

//фильтр текста, точные совпадения
class Text implements Filterable
{

    public static function apply(FormBuilderInterface $builder, $value)
    {
        return $builder->where('message', 'LIKE','%'.$value.'%');
    }
}
<?php

namespace App\Services\Filters;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\MakerBundle\Str;

trait BaseSearch
{
    protected function getObject()
    {
        $className = self::MODEL;
        return new $className;
    }

    protected function getNameSpace()
    {
        return (new \ReflectionObject($this))->getNamespaceName();
    }

    public function apply(Request $request)
    {
        $query = $this->applyObjectFromRequest($request, $this->getObject()->newQuery());
        return $this->getResults($query);
    }

    private function applyObjectFromRequest(Request $request, FormBuilderInterface $query)
    {
        foreach ($request->all() as $filterName => $value) {
            if (!$value && $value !== "0") {
                continue;
            }

            $object = $this->createFilterObject($filterName);

            if ($this->isValidObject($object)) {
                $query = $object::apply($query, $value);
            }
        }

        return $query;
    }

    private function createFilterObject($name)
    {
        return $this->getNameSpace() . "\\" . Str::studly($name);
    }

    private function isValidObject($decorator)
    {
        return class_exists($decorator);
    }

    private function getResults(FormBuilderInterface $query) {
        return $query;
    }
}
<?php

namespace App\EloquentFilters\Todo;


use Fouladgar\EloquentBuilder\Support\Foundation\Contracts\IFilter as Filter;
use Illuminate\Database\Eloquent\Builder;

class ApiTokenFilter implements Filter
{
    /**
     * Undocumented function.
     *
     * @param Builder $builder
     * @param mixed $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder;
    }
}

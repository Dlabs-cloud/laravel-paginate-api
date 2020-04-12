<?php

namespace Dlabs\PaginateApi;


use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class PaginateApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMacro();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerMacro()
    {
        $macro = function ($perPage = 20, $offset = 0, $columns = ['*'], array $options = []) {

            if (!$perPage) {
                $perPage = request('limit') ?? $perPage;
            }

            $this
                ->skip(request('offset') ?? $offset)
                ->limit($perPage);

            $total = $this->toBase()->getCountForPagination();

            return new PaginateApiAwarePaginator($this->get($columns), $perPage, $total, $offset, $options);
        };

        QueryBuilder::macro('paginateApi', $macro);

        EloquentBuilder::macro('paginateApi', $macro);
    }
}

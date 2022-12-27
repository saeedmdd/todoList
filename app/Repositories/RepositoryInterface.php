<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @param array|string $columns
     * @param array|string $relations
     * @return Collection
     */
    public function getAll(array|string $columns = ["*"], array|string $relations = []): Collection;

    /**
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model|null
     */
    public function findOrFail(
        int   $modelId,
        array $columns = ["*"],
        array $relations = [],
        array $appends = []
    ): ?Model;

    /**
     * @param array $columns
     * @return Model|null
     */
    public function create(array $columns): ?Model;

    /**
     * @param Model $model
     * @param array $columns
     * @return bool
     */
    public function update(Model $model, array $columns): bool;

    /**
     * @param Model $model
     * @return bool
     */
    public function deleteOrFail(Model $model): bool;

    /**
     * @param array|string $columns
     * @param array|string $relations
     * @param int $paginate
     * @param string $pageName
     * @param $page
     * @return LengthAwarePaginator
     */
    public function paginate(
        array|string  $columns = ["*"],
        array|string  $relations = [],
        int    $paginate = 15,
        string $pageName = 'page',
               $page = null
    ): LengthAwarePaginator;
}

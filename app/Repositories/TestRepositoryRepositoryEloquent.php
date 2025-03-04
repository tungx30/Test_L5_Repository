<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TestRepositoryRepository;
use App\Entities\TestRepository;
use App\Validators\TestRepositoryValidator;

/**
 * Class TestRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TestRepositoryRepositoryEloquent extends BaseRepository implements TestRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TestRepository::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

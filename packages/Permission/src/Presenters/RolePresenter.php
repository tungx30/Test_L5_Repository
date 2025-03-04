<?php

namespace Packages\Permission\Presenters;

use Packages\Permission\Transformers\PermissionGroupTransformer;
use Packages\Permission\Transformers\PermissionTransformer;
use Packages\Permission\Transformers\RoleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace ELEARNING\Users\Presenters;
 */
class RolePresenter extends FractalPresenter
{
    /**
     * @var string
     */
    protected $resourceKeyItem = 'Role';

    /**
     * @var string
     */
    protected $resourceKeyCollection = 'Role';

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoleTransformer();
    }
}

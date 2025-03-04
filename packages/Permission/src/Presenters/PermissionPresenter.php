<?php

namespace Packages\Permission\Presenters;

use Packages\Permission\Transformers\PermissionGroupTransformer;
use Packages\Permission\Transformers\PermissionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace ELEARNING\Users\Presenters;
 */
class PermissionPresenter extends FractalPresenter
{
    /**
     * @var string
     */
    protected $resourceKeyItem = 'PermissionGroup';

    /**
     * @var string
     */
    protected $resourceKeyCollection = 'PermissionGroup';

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PermissionTransformer();
    }
}

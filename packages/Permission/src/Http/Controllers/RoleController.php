<?php

namespace Packages\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Permission\Repositories\Contracts\RoleRepository;

/**
 * Class RoleController.
 */
class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $repository;

    /**
     * RoleController constructor.
     *
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $roles = $this->repository->all();

        return response()->json([
            'status' => true,
            'message' => __('messages.common.success'),
            'data' => $roles,
        ]);
    }
}

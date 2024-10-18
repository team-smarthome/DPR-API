<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\UserRoleRequest;
use App\Repositories\Interfaces\UserRoleRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

class UserRoleController extends Controller
{
    use ResponseTrait;

    protected $userRoleRepositoryInterface;

    public function __construct(UserRoleRepositoryInterface $userRoleRepositoryInterface)
    {
        $this->userRoleRepositoryInterface = $userRoleRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->userRoleRepositoryInterface->get($request);
    }

    public function store(Request $request)
    {
        try {
            $userRoleRequest = new UserRoleRequest();
            $data = $userRoleRequest->validate($request);
            return $this->userRoleRepositoryInterface->create($data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('User Role Already Exist');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $userRoleRequest = new UserRoleRequest();
            $data = $userRoleRequest->validate($request);

            return $this->userRoleRepositoryInterface->update($id, $data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('User Role Already Exist');
        }
    }

    public function destroy($id)
    {
        return $this->userRoleRepositoryInterface->delete($id);
    }
}

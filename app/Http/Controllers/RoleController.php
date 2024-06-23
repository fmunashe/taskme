<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends BaseController
{

    public function index(): JsonResponse
    {
        $roles = Role::query()->latest()->paginate(5);
        return $this->buildSuccessResponse($roles, 'Records retrieved successfully');
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = Role::query()->create($request->all());
        return $this->buildSuccessResponse($role, "Role created successfully");
    }

    public function show($roleId): JsonResponse
    {
        $role = Role::query()->firstWhere('id', '=', $roleId);
        if ($role == null) {
            return $this->buildErrorResponse("Role with id " . $roleId . " not found");
        }
        return $this->buildSuccessResponse($role, 'Role retrieved successfully');
    }


    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();
        return $this->buildSuccessResponse($role, "Role updated successfully");
    }


    public function destroy(Role $role): JsonResponse
    {
        $role->delete();
        return $this->buildSuccessResponse(null, "Role removed successfully");
    }
}

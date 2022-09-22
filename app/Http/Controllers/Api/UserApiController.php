<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    use HttpResponse;

    public function usersList(): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('access_users')) {
            return $this->errorResponse(null, 'You do not have right permissions', 401);
        }

        return $this->successResponse(UserResource::collection(User::all()), 'List of users');
    }
}

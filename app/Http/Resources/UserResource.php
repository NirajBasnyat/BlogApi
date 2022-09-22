<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => ucfirst($this->name),
            'email' => $this->email,
            'roles' => $this->roles->pluck('name') ?? [],
//            'roles.permissions' => $this->getPermissionsViaRoles() ?? [],
            'permissions' => $this->getAllPermissions()->pluck('name') ?? [],
        ];
    }
}

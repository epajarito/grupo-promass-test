<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'type' => 'users',
            'attributes' => [
                'name' => $this->resource->name,
                'last_name' => $this->resource->last_name,
                'telephone' => $this->resource->telephone,
                'email' => $this->resource->email,
                'role' => $this->resource->role,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated,
                'last_login' => $this->resource->last_login,
                'token' => $this->createToken('auth-token')->plainTextToken,
                'avatar' => $this->resource->avatar_url,
            ]
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\SaveRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Services\Users\PdfReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Get all active users
     *
     * @return AnonymousResourceCollection
    */
    public function index(): AnonymousResourceCollection
    {
        $users = User::latest()->paginate();

        return UserResource::collection($users);
    }

    /**
     * Store new user
     *
     * @param SaveRequest $request
     * @return UserResource
    */
    public function store(SaveRequest $request): UserResource
    {
        $this->authorize('create', auth()->user());
        $user = User::create($request->validated());
        $user->setAvatar();

        return new UserResource($user);
    }

    /**
     * Update user
     *
     * @param SaveRequest $request
     * @param User $user
     *
     * @return UserResource
    */
    public function update(SaveRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        $user->setAvatar(true);

        return new UserResource($user);
    }

    /**
     * Delete user
     *
     * @param User $user
     * @return Response
    */
    public function destroy(User $user): Response
    {
        $this->authorize('delete', $user);
        $user->delete();

        return response()->noContent();
    }


    /**
     * Get url pdf
     *
     * @param PdfReport $pdfReport
     * @return JsonResponse
     */
    public function getUrlPdf(PdfReport $pdfReport): JsonResponse
    {
        return response()->json(['url' => $pdfReport->handle()]);
    }
}


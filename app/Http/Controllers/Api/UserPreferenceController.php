<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPreferenceStoreRequest;
use App\Http\Requests\UserPreferenceUpdateRequest;
use App\Http\Resources\UserPreferenceResource;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/user-preference/list",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function list(Request $request)
    {
        $data = $this->UserPreferenceService->paginate();
        return UserPreferenceResource::collection($data);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/user-preference/store",
     *     summary="Store user preferences",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="preferences[source]", type="string"),
     *                 @OA\Property(property="preferences[published_at][from]", type="string"),
     *                 @OA\Property(property="preferences[published_at][to]", type="string"),
     *                 @OA\Property(property="preferences[category]", type="string"),
     *                 @OA\Property(property="name", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preferences saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function store(UserPreferenceStoreRequest $request)
    {

        $this->UserPreferenceService->create($request['name'], $request['preferences']);

        return response()->json(['message' => 'Preferences has been saved successfully.']);
    }


    /**
     * @OA\Put(
     *     path="/api/v1/user-preference/update",
     *     summary="Update user preferences",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="preferences[source]", type="string"),
     *                 @OA\Property(property="preferences[published_at][from]", type="string"),
     *                 @OA\Property(property="preferences[category]", type="string"),
     *                 @OA\Property(property="name", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preferences updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(UserPreferenceUpdateRequest $request)
    {
        $this->UserPreferenceService->update($request['name'], $request['preferences']);

        return response()->json(['message' => 'Preferences updated successfully.']);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/user-preference/delete",
     *     summary="Delete user preferences",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preferences deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $this->UserPreferenceService->destroy($validatedData['name']);

        return response()->json(['message' => 'Preferences deleted successfully.']);
    }

}

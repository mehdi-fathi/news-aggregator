<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPreferenceStoreRequest;
use App\Http\Requests\UserPreferenceUpdateRequest;
use App\Http\Resources\NewsResource;
use App\Http\Resources\UserPreferenceResource;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    public function list(Request $request)
    {
        $data = $this->UserPreferenceService->paginate();
        return UserPreferenceResource::collection($data);
    }

    // Store preferences
    public function store(UserPreferenceStoreRequest $request)
    {

        $this->UserPreferenceService->create($request['name'], $request['preferences']);

        return response()->json(['message' => 'Preferences has been saved successfully.']);
    }

    // Update preferences
    public function update(UserPreferenceUpdateRequest $request)
    {
        $this->UserPreferenceService->update($request['name'], $request['preferences']);

        return response()->json(['message' => 'Preferences updated successfully.']);
    }

    // Delete preferences
    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $this->UserPreferenceService->destroy($validatedData['name']);

        return response()->json(['message' => 'Preferences deleted successfully.']);
    }

}

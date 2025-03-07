<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

final class UserController extends Controller
{
    /**
     * Display a listing of the users.
     * 
     * For Owners: Returns the authenticated owner and all their workers.
     * For Workers: Returns only the authenticated worker.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if ($user->isOwner()) {
            // Return the owner and all their workers
            $workers = $user->workers()->get();
            return response()->json([
                'owner' => $user,
                'workers' => $workers,
            ]);
        } else {
            // Return only the worker
            return response()->json([
                'user' => $user,
            ]);
        }
    }

    /**
     * Store a newly created worker user in storage.
     * 
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $owner = $request->user();
        
        // Double-check that the user is an owner
        if (!$owner->isOwner()) {
            return response()->json(['message' => 'Unauthorized. Only owners can create worker accounts.'], 403);
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['sometimes', 'string', Password::defaults()],
        ]);

        // Generate a random password if not provided
        $password = $validated['password'] ?? Str::password(12);
        
        $worker = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($password),
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);

        // Hide the password in the response if it was generated
        $responseData = [
            'worker' => $worker,
        ];
        
        if (!isset($validated['password'])) {
            $responseData['generated_password'] = $password;
            $responseData['message'] = 'A worker account has been created with a generated password. Please share this password with the worker.';
        }

        return response()->json($responseData, 201);
    }
} 
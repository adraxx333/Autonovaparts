<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * Muestra la página de inicio de sesión.
     *
     * @return \Inertia\Response
     */
    public function show()
    {
        return inertia('Login');
    }

    /**
     * Maneja la solicitud de inicio de sesión.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);

            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'error' => 'No existe un usuario registrado con este email.',
                ]);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'error' => 'Password incorrecta.',
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Se ha iniciado sesión!',
                'redirect' => route('dashboard')
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Maneja el registro de nuevos usuarios.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user = User::where('email', $validated['email'])->first();

            if ($user) {
                throw ValidationException::withMessages([
                    'error' => 'Usuario ya registrado con este email!',
                ]);
            }

            $newUser = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($newUser);
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'redirect' => route('dashboard')
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

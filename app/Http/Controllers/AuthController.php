<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();

        if($user->status == "activo"):
            session(['user' => $user]);

            $dados = [
                'token' => $token,
                'user' => $user,
            ];
            return $this->respondWithToken($dados);
        else:
            return response()->json(['error' => 'Utilizador inactivo! Contacte o admin principal para voltar a fazer login com este utilizador.'], 403);
        endif;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function addUser(Request $request){
        $user = User::create([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'level' => 1,
            'status' => 'activo'
        ]);

        return response()->json($user, 201);
    }
    public function updateUser(Request $request, $field, $id) {

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'error'=> 'User not found!'
            ], 404);
        }
        if ($field == 'name'){
            $user->name = $request->input('name');
        }
        if ($field == 'email'){
            $user->email = $request->input('email');
        }
        if ($field == 'password'){
            $user->password = Hash::make($request->input('password'));
        }
        if ($field == 'status'){
            $user->status = $request->input('status');
        }
        $user->save();

        return response()->json([
            'data'=> $user,
            'has'=> $request->has('name')

        ], 200);
    }

    public function deleteUser($id) {

        try {
            $user = JWTAuth::parseToken()->authenticate();

            if ($user->level !== 0){
                return response()->json(['message', 'Unauthorized Level'], 403);
            }
            $userToUpdate = User::find($id);

            if (!$userToUpdate) {
                return response()->json(['message' => 'Utilizador não encontrado!'], 403);
            }else {
                if ($userToUpdate->status == 'activo'){
                    $userToUpdate->status = 'inactivo';
                    $userToUpdate->save();
                    return response()->json(['message' => 'User status updated successfully'], 200);

                }else {
                    return response()->json(['message' => 'Utilizador está Inactivo!'], 403);

                }
            }
        }
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'Token not provided or invalid'], 401);

        }

    }
}

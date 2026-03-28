<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

 class AuthController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {

            
        }

        /**
         * Store a newly created resource in storage.
         */
        public function register(RegisterRequest $request): JsonResponse
        {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);

            $user->load('role');
           if ($user->role->name == "freelancer") {
             Freelancer::create([
                'user_id'      => $user->id,
                'rating'       => 0,
                'portfolio'    => $validated['portfolio'] ,
                'price'        => $validated['price'] ,
                'availability' => 'available',
            ]);
        } 
        elseif ($user->role->name == "client") {
            Client::create([
                'user_id'     => $user->id,
                'entreprise'  => $validated['entreprise'] ,
                'description' => $validated['description'],
            ]);
        }
        
        $token = $user->createToken('user_token')->plainTextToken;
 
        return response()->json([
            'message' => 'Inscription réussie',
            'user'    => $user,
            'token'   => $token,
        ], 201);
        }

        public function login(LoginRequest $request)
        {
           $validated = $request->validated();
 
        $user = User::where('email', $validated['email'])->first();
 
         if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'incorrects email ou password. ',
            ], 401);
        }
 
         $user->load('role');

         $token = $user->createToken('user_token')->plainTextToken;
 
         return response()->json([
            'success' => true,
            'message' => 'Connexion réussie.',
            'data'    => [
                'user'  => $user,
                'token' => $token,
            ],
        ], 200);
        }

       public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
 
        return response()->json([
            'message' => 'Déconnexion réussie',
        ],200);
    }

  public function profile(Request $request)
{
    $user = $request->user();

    if ($user->role->name == "freelancer") {
        $user->load('freelancer');
    } elseif ($user->role->name == "client") {
        $user->load('client'); 
    }
    return response()->json([
        "success" => true,
        "message" => "Profil utilisateur récupéré.",
        "data" => [
            "user" => $user
        ]
    ], 200);
}
        
    }

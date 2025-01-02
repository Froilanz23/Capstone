<?php

namespace App\Http\Middleware;

use App\Models\Artist;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManagement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $roles = [
            'admin' => 1,
            'artist' => 2,
            'customer' => 3,
        ];
    
        $authUser = Auth::user();
        $authUserRole = $authUser->role;

        //     // Allow artist to access customer features
        // if ($role === 'customer' && $authUserRole === $roles['artist']) {
        //     return $next($request);
        // }

    
        // Handle role-specific logic
        if ($authUserRole !== $roles[$role]) {
            // Redirect based on user's actual role
            return match ($authUserRole) {
                $roles['admin'] => redirect()->route('admin.index'),
                $roles['artist'] => redirect()->route('artist.index'),
                $roles['customer'] => redirect()->route('user.index'),
                default => redirect()->route('login'),
            };
        }
    
        // Allow access if roles match
        return $next($request);
    }
}    
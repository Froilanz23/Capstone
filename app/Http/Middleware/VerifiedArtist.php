<?php

namespace App\Http\Middleware;

use App\Models\Artist;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifiedArtist
{
    public function handle(Request $request, Closure $next)
    {

        $user = Auth::user();

        if ($user && $user->role === 2) {
            $artist = Artist::where('user_id', $user->id)->first();
            

            if (!$artist || $artist->verification_status !== 'approved') {
                return redirect()->route('artist.artists')->with('error', 'Your account is not verified yet.');
            }
        }

        return $next($request);
    }
}
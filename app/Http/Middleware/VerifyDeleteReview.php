<?php

namespace App\Http\Middleware;

use App\Models\Review;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyDeleteReview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $review = $request->route('review');

        if ($review->user_id !== Auth::user()->id || Auth::user()->is_admin == false) {
            return response()->json([
                'error' => 'Unauthorized'
            ],403);
        }

        return $next($request);
    }
}

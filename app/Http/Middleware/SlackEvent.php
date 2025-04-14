<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SlackEvent {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle( Request $request, Closure $next ) {
        // Slack verification token is not passed in request
        if ( empty( $request->all()[ 'token' ] ) ) {
            return response()->json(['error' => 'Missing verification token'], 401);
        }

        // Incorrect Slack verification token is passed in request
        if ( $request->all()[ 'token' ] !== env( 'VERIFICATION_TOKEN' ) ) {
            return response()->json(['error' => 'Invalid verification token'], 401);
        }

        if ( $request->json()->has( 'challenge' ) ) {
            return response()->json(['challenge' => $request->json()->get('challenge')], 200);
        }

        return $next( $request );
    }
}

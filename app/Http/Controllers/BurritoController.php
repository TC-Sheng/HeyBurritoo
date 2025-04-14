<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BurritoController extends Controller
{
    public function slackChallenge(Request $request)
    {
        return response()->json([
            'challenge' => $request->input('challenge')
        ]);
    }
} 
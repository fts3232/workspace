<?php

namespace fts\OAuth2;

use App\Http\Controllers\Controller;

class OAuthController extends Controller
{
    public function token()
    {
        try {
            $token = app('fts\OAuth2\OAuth2')->getToken(app('request'));
            return response()->json($token);
        } catch (\Exception $e) {
            return response()->json(['error'=>'get token fail']);
        }
    }
}

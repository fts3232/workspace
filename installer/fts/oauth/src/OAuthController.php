<?php

namespace fts\OAuth2;

use App\Http\Controllers\Controller;

class OAuthController extends Controller
{
    public function token()
    {
        $return = app('fts\OAuth2\OAuth2')->getToken(app('request'));
        return response()->json($return);
    }
}

<?php

namespace fts\OAuth;

use App\Http\Controllers\Controller;

class OAuthController extends Controller
{
    public function token()
    {
        return response()->json(app('fts\OAuth\OAuth')->getToken(app('request')));
    }
}

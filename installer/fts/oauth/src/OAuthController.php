<?php

namespace fts\OAuth;

use App\Http\Controllers\Controller;
use OAuth2\HttpFoundationBridge\Request;
use OAuth2\HttpFoundationBridge\Response;

class OAuthController extends Controller
{
    public function token()
    {
        $bridgedRequest = Request::createFromRequest(app('request'));
        $bridgedResponse = new Response();
        return app('fts\OAuth\OAuth')->token($bridgedRequest, $bridgedResponse);
    }
}

<?php

namespace fts\OAuth;

use App\Http\Controllers\Controller;
use OAuth2\Request;
use OAuth2\Response;

class OAuthController extends Controller
{
    public function token()
    {
        $bridgedRequest = Request::createFromRequest(Request::instance());
        $bridgedResponse = new  Response();

        return app('fts\OAuth\OAuth')->token($bridgedRequest, $bridgedResponse);
    }
}

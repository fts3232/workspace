<?php

namespace App\Http\Controllers;

/**
 * 标签
 *
 * Class TagsController
 * @package App\Http\Controllers
 */
class TagsController extends Controller
{

    public function tag($name)
    {
        return view('tags/tag', ['name' => $name]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Setting;
use Illuminate\Http\Request;

class AVController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    private function scaleDir($dir, $filename = null)
    {
        $paths = [];
        $dirHandler = opendir($dir);
        while (($name = readdir($dirHandler)) !== false) {
            $data = [];
            $originPath = $this->join($dir, $name);
            //$name = iconv('gbk', 'utf-8', $name);
            $path = $this->join($dir/*iconv('gbk', 'utf-8', $dir)*/, $name);
            if (is_dir($originPath) && $name != '.' && $name != '..') {
                if ((!empty($filename) && strstr($name, $filename) !== false) || empty($filename)) {
                    $data['title'] = $name;
                    $data['path'] = $path;
                    $data['time'] = date("Y-m-d H:i:s", filectime($originPath));
                    $data = array_merge($data, $this->openDir($originPath));
                    $paths[] = $data;
                }
            }
        }
        return $paths;
    }

    private function openDir($dir)
    {
        $paths = [];
        $dirHandler = opendir($dir);
        while (($name = readdir($dirHandler)) !== false) {
            $originPath = $this->join($dir, $name);
            //$name = iconv('gbk', 'utf-8', $name);
            $path = $this->join($dir/*iconv('gbk', 'utf-8', $dir)*/, $name);
            if (is_file($originPath)) {
                $ext = strtolower(pathinfo($originPath)['extension']);
                if (in_array($ext, ['jpg', 'gif', 'png'])) {
                    $paths['cover'] = 'http://localhost/movie/' . str_replace('E:\download', '', $path);
                } elseif (in_array($ext, ['avi', 'mp4', 'mkv'])) {
                    $paths['video'] = str_replace('\\', '/', $path);
                }
            }
        }
        return $paths;
    }

    private function join($dir, $path)
    {
        if (substr($dir, 0, strlen($dir) - 1) !== DIRECTORY_SEPARATOR) {
            $dir = $dir . DIRECTORY_SEPARATOR;
        }
        return $dir . $path;
    }

    public function getPic(Request $request)
    {
        $file = $request->input('file');
        $file = iconv('utf-8', 'gbk', $file);
        $content = file_get_contents($file);
        return response($content, 200, [
            'Content-Type' => 'image/jpg',
        ]);
    }

    private function deleteDir($dir)
    {
        $dirHandler = opendir($dir);
        while (($name = readdir($dirHandler)) !== false) {
            $originPath = $this->join($dir, $name);
            if (is_dir($originPath) && $name != '.' && $name != '..') {
                $this->deleteDir($originPath);
            } elseif (is_file($originPath)) {
                unlink($originPath);
            }
        }
        rmdir($dir);
        return true;
    }

    public function delete(Request $request)
    {
        $return = ['status' => true];
        try {
            $path = $request->input('path');
            $path = iconv('utf-8', 'gbk', $path);
            $this->deleteDir($path);
        } catch (Exception $e) {
            $return = ['status' => false, 'msg' => '删除失败'];
        }
        return response()->json($return);
    }

    //
    public function get(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);
        $key = $request->input('searchKey');
        $value = $request->input('searchValue', null);
        $offset = ($page - 1) * $size;
        $dir = 'E:\download';
        $dirs = $this->scaleDir($dir, $value);
        array_multisort(array_column($dirs, 'time'), SORT_DESC, $dirs);
        return response()->json(['status' => true, 'list' => $dirs]);
    }

    public function setting(Request $request)
    {
        $url = $request->input('url');
        $result = Setting::add('javbus_url', $url);
        return response()->json(['status' => $result]);
    }

    public function setCover(Request $request){
        $path = $request->input('path');
        $cover = $request->file('cover');
        $cover->move($path, 'cover.jpg');
        return response()->json(['status' => true, 'cover' =>  'http://localhost/movie/' . str_replace('E:\download', '', $path).'/cover.jpg']);
    }

    public function openPath(Request $request){
        $path = $request->input('path');
        passthru("start {$path}");
        return response()->json(['status' => true]);
    }
}

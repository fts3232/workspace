<?php

class Staticize
{
    private $staticDir = './static/';

    private $map = array(
        'name'
    );

    public function view($view, $params)
    {
        $fileName = $this->staticDir . $view . '.html';
        if (!$this->check($fileName,$params)) {
            $view = view($view, $params);
            $html = $view->__toString();
            $this->create($fileName, $html);
        } else {
            $html = file_get_contents($fileName);
        }
        return $html;
    }

    public function check($fileName, $params)
    {
        $result = true;
        try{
            if(!file_exists($fileName)){
                throw new Exception('');
            }
            foreach ($params as $param) {
                if (in_array($param, $map)) {

                }
            }
        }catch(Exception $e){
            $result = false;
        }
        return $result;
    }

    public function create($fileName, $html)
    {
        file_put_contents($fileName, $html);
    }
}

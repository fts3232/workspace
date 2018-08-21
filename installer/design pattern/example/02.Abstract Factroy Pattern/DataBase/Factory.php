<?php

namespace Database;

class Factory
{
    public function make($color, $shape)
    {
        $shape = $this->getShape($shape);
        var_dump($shape);
        $color = $this->getColor($color);
        var_dump($color);
    }

    public function getShape($shape)
    {
        switch ($shape) {
            case 'circle':
                return new Circle();
        }
        return null;
    }

    public function getColor($color)
    {
        switch ($color) {
            case 'red':
                return new Red();
            case 'blue':
                return new Blue();
            case 'yellow':
                return new Yellow();
        }
        return null;
    }
}

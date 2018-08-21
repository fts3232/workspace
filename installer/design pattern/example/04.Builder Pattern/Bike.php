<?php

namespace Builder;

class Bike
{
    private $tyre;

    private $frame;

    private $gps;

    public function setTyre($tyre)
    {
        $this->tyre = $tyre;
    }

    public function setFrame($frame)
    {
        $this->frame = $frame;
    }

    public function setGPS($gps)
    {
        $this->gps = $gps;
    }
}

<?php

interface EventEmitterInterface
{
    public function on($event, $listener);
    public function once($event, $listener);
    public function removeListener($event, $listener);
    public function removeAllListeners($event = null);
    public function listeners($event);
    public function emit($event, array $arguments = array());
}

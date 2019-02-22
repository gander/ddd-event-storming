<?php

interface State
{
    public function touch();
}

class Off implements State
{
    public function touch()
    {
        echo 'WLACZAM SIE!!!' . PHP_EOL;

        return random_int(1, 10) < 2 ? new Crash() : new On();
    }
}

class On implements State
{
    public function touch()
    {
        echo 'WYLACZAM SIE!!!' . PHP_EOL;

        return new Off();
    }
}

class Crash implements State
{
    public function touch()
    {
        echo 'CRASH!!!!!' . PHP_EOL;

        return $this;
    }
}

class Lamp
{
    /**
     * @var State
     */
    private $state;

    /**
     * Lamp constructor.
     * @param State $state
     */
    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function touch()
    {
        $this->state = $this->state->touch();
    }
}

$lamp = new Lamp(new Off());

$lamp->touch();
$lamp->touch();
$lamp->touch();
$lamp->touch();
$lamp->touch();
$lamp->touch();
$lamp->touch();
$lamp->touch();
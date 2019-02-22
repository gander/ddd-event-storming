<?php

$beings = [
    new Cat(),
    new Dog(),
    new Monkey(),
    new Cow(),
    new Neighbour(),
];

foreach ($beings as $being) {
    $being->getStomach()->setContent(new Food());

    // Polimorficzna operacja
    $being->eat(new Food());
}


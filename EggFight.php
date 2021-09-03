<?php

function generateEggs(string $name, int $chances, int $amount): stdClass
{
    $egg = new stdClass();
    $egg->name = $name;
    $egg->chances = $chances;
    $egg->amount = $amount;
    return $egg;
}

$playerEggs = [
    generateEggs("Wooden", 7, 2),
    generateEggs("Normal", 3, 3),
    generateEggs("Steel", 9, 1),
    generateEggs("Glass", 5, 1)
];

$computerEggs = [
    generateEggs("Rubber", rand(6, 9), rand(1, 3)),
    generateEggs("Cloth", rand(1, 5), rand(1, 2)),
    generateEggs("Plastic", rand(3, 7), rand(1, 4)),
    generateEggs("Raw", rand(2, 6), rand(1, 3))
];

foreach ($playerEggs as $egg) {
    echo "{$egg->name} ({$egg->amount}) - {$egg->chances}";
    echo " | ";
}

echo PHP_EOL;

foreach ($computerEggs as $egg) {
    echo "{$egg->name} ({$egg->amount}) - {$egg->chances}";
    echo " | ";
}

echo PHP_EOL;
echo "______________________________________________________________" . PHP_EOL;
echo "Let's get ready to Rumble!!!!!! !! ! !!" . PHP_EOL;

while (true) {
    if (count($playerEggs) <= 0 || count($computerEggs) <= 0) break;

    $playerEgg = $playerEggs[array_rand($playerEggs)];
    $computerEgg = $computerEggs[array_rand($computerEggs)];

    echo "$playerEgg->name egg ($playerEgg->chances) is fighting against $computerEgg->name egg ($computerEgg->chances)" . PHP_EOL;

    $totalChances = $playerEgg->chances + $computerEgg->chances;

    $playerSides = 0;
    $computerSides = 0;

    while ($playerSides != 2 && $computerSides != 2) {
        $randomChances = rand(1, $totalChances + 1);
        if ($randomChances <= $playerEgg->chances) {
            $playerSides++;
            echo "Players $playerEgg->name egg has crushed the side of Computers $computerEgg->name egg" . PHP_EOL;
        } else if ($randomChances === $totalChances + 1) {
            $playerSides++;
            $computerSides++;
            echo "Both eggs has crushed each other sides" . PHP_EOL;
        } else {
            $computerSides++;
            echo "Computers $computerEgg->name egg has crushed the side of Players $playerEgg->name egg" . PHP_EOL;
        }
    }

    $randomChances = rand(1, $totalChances + 1);
    $existed = false;

    if ($playerSides == $computerSides) {
        $playerEgg->amount--;
        if ($playerEgg->amount <= 0) {
            unset($playerEggs[array_search($playerEgg, $playerEggs)]);
        }
        $computerEgg->amount--;
        if ($computerEgg->amount <= 0) {
            unset($computerEggs[array_search($computerEgg, $computerEggs)]);
        }
        echo "It's a draw. Both eggs go into trash can" . PHP_EOL;
        echo "___________________________________________________________________________________" . PHP_EOL;
    } else if ($playerSides == 2) {
        if ($playerEgg->name === $computerEgg->name) {
            $existed = true;
            $playerEgg->amount++;
        }
        if ($existed === false) {
            $newEgg = clone $computerEgg;
            $newEgg->amount = 1;
            $playerEggs[] = $newEgg;
        }
        $computerEgg->amount--;
        if ($computerEgg->amount <= 0) {
            unset($computerEggs[array_search($computerEgg, $computerEggs)]);
        }
        echo "Players $playerEgg->name egg has won the battle. He takes away Computers $computerEgg->name egg" . PHP_EOL;
        echo "___________________________________________________________________________________" . PHP_EOL;
    } else {
        if ($computerEgg->name === $playerEgg->name) {
            $existed = true;
            $computerEgg->amount++;
        }
        if ($existed === false) {
            $newEgg = clone $playerEgg;
            $newEgg->amount = 1;
            $computerEggs[] = $newEgg;
        }
        $playerEgg->amount--;
        if ($playerEgg->amount <= 0) {
            unset($playerEggs[array_search($playerEgg, $playerEggs)]);
        }
        echo "Computers $computerEgg->name egg has won the battle. He takes away Players $playerEgg->name egg" . PHP_EOL;
        echo "___________________________________________________________________________________" . PHP_EOL;
    }
}

if (count($playerEggs) <= 0) {
    echo "Computer has won all battles!" . PHP_EOL;
}

if (count($computerEggs) <= 0) {
    echo "Player has won all battles!" . PHP_EOL;
}
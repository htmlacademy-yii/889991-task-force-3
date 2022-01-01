<?php
use Taskforce\logic\Task;
use Taskforce\exceptions\CastomException;

require_once "vendor/autoload.php";
try {
$task1 = new Task('working', 1, 1, );
echo($task1->getAvailableActions('customer')->getTitle());
} catch (CastomException $e) {
    echo($e->getMessage());
}
try {
$task2 = new Task('new', 2, 1, 2);
echo($task2->getAvailableActions('executor')->getTitle());
} catch (CastomException $e) {
    echo($e->getMessage());
}

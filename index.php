<?php
use Taskforce\logic\Task;
use Taskforce\exceptions\CastomException;
use Taskforce\exceptions\FileFormatException;
use Taskforce\exceptions\SourceFileException;
use Taskforce\utils\Converter;

require_once "vendor/autoload.php";

try {
    $converter = new Converter('./data/categories.csv');
    $converter->import();
    $converter->writeSqlFile('./data');
} catch (SourceFileException $e) {
    echo("Не удалось обработать csv файл: " .$e->getMessage());
} catch (FileFormatException $e) {
    echo("Не удалось обработать csv файл: " .$e->getMessage());
}
try {
    $converter2 = new Converter('./data/cities.csv');
    $converter2->import();
    $converter2->writeSqlFile('./data');
} catch (SourceFileException $e) {
    echo("Не удалось обработать csv файл: " .$e->getMessage());
} catch (FileFormatException $e) {
    echo("Не удалось обработать csv файл: " .$e->getMessage());
}


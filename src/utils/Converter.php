<?php

namespace Taskforce\utils;

use Taskforce\exceptions\FileFormatException;
use Taskforce\exceptions\SourceFileException;
use SplFileObject;
use RuntimeException;

class Converter
{
    private  $filename;
    private  $columns = [];
    private  $fileObject;
    private $result = [];
    private $error = null;

    /**
     * Converter constructor.
     * @param $filename - Путь к файлу csv
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function import():void
    {
        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);
        }
        catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        if ($this->fileObject->getExtension() != 'csv') {
            throw new FileFormatException('Неверный формат файла');
        }

        $this->columns[] = $this->getHeaderData();

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }
    }

    public function writeSqlFile(string $dirName):void
    {
        $baseName = $this->fileObject->getBasename(".csv");
        $columns_by_row = implode(", ", $this->columns[0]);
        $content_file = "INSERT INTO $baseName ($columns_by_row) \n VALUES \n";
        $values = "";
        foreach($this->result as $value) {
            $value_by_row = implode(",", $value);
            $value_by_row = preg_replace('~[^,]+(?=(,|$))~', "'$0'", $value_by_row);
            $values .= "($value_by_row), \n";
        }
        $values = preg_replace('/(,)(?=\s*$)/s', ";", $values);
        $content_file .= $values;
        $filenameSql = "$dirName/$baseName.sql";

        if (!file_put_contents($filenameSql, $content_file)) {
            throw new SourceFileException("Не удалось экспортировать данные в файл {$sqlPath}");
        }
    }

    public function getData():array
    {
        return $this->result;
    }
    public function getColumns():array
    {
        return $this->columns;
    }

    private function getHeaderData():?array
    {
        $this->fileObject->rewind();
        $data = $this->fileObject->fgetcsv();

        return $data;
    }

    private function getNextLine():?iterable
    {
        $result = null;

        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return $result;
    }

}

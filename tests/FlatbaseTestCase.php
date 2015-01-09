<?php

namespace Flatbase;

use Flatbase\Query\DeleteQuery;
use Flatbase\Query\InsertQuery;
use Flatbase\Storage\Filesystem;

abstract class FlatbaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getFlatbase()
    {
        $storage = new Filesystem(__DIR__ . '/storage');
        $flatbase = new Flatbase($storage);
        return $flatbase;
    }

    protected function getFlatbaseWithSampleData()
    {
        $flatbase = $this->getFlatbase();

        // Empty it
        $deleteQuery = new DeleteQuery();
        $deleteQuery->setCollection('users');
        $flatbase->execute($deleteQuery);

        $data = [
            [
                'name' => 'Adam',
                'age' => 23,
                'height' => "6'3",
                'company' => 'Foo Inc'
            ],
            [
                'name' => 'Adam',
                'age' => 24,
                'height' => "6'4",
                'company' => 'Foo Inc'
            ],
            [
                'name' => 'Adam',
                'age' => 25,
                'height' => "6'5",
                'company' => 'Bar Inc'
            ],
            [
                'name' => 'Michael',
                'age' => 26,
                'height' => "6'6",
                'company' => 'Foo Inc'
            ],
        ];

        foreach ($data as $record) {
            $query = new InsertQuery();
            $query->setCollection('users');
            $query->setValues($record);
            $flatbase->execute($query);
        }

        return $flatbase;
    }
}
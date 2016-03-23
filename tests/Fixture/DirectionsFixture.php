<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DirectionsFixture
 *
 */
class DirectionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ip' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'latFrom' => ['type' => 'float', 'length' => 10, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'lngFrom' => ['type' => 'float', 'length' => 10, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'latTo' => ['type' => 'float', 'length' => 10, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'lngTo' => ['type' => 'float', 'length' => 10, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_bin'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => '',
            'ip' => 'Lorem ipsum dolor sit amet',
            'latFrom' => 1,
            'lngFrom' => 1,
            'latTo' => 1,
            'lngTo' => 1,
            'created' => '2016-03-24 06:52:26',
            'modified' => '2016-03-24 06:52:26',
            'active' => 1
        ],
    ];
}

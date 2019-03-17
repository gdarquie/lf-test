<?php

namespace App\Tests;

use App\Service\DateConvertorService;
use PHPUnit\Framework\TestCase;

/**
 * It's just a first unit test : the application needs more functional and unit tests, a test database has to be set up
 *
 *
 * Class DateConvertorServiceTest
 * @package App\Tests
 */
class DateConvertorServiceTest extends TestCase
{
    //todo : add more tests for other classes

    public function testSomething()
    {
        $dateConvertor = new DateConvertorService();
        $date = $dateConvertor->convertDate('7-janv.-19');
        $this->assertEquals('1546819200', $date->getTimestamp());
    }
}

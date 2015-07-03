<?php

class TenableTest extends \PHPUnit_Framework_TestCase
{
    private $db;

    /**
     * Setup TenableDB connection for SQLite tests. 
     */
    public function setUp()
    {
        $this->db = new TenableDB();
    }
    
    /**
     * Retrieve the 10th through 20th records in the 'Car' table ordered by 
     * lowest to highest id using SQLite syntax.
     */
    public function testQOne()
    {
        $query = file_get_contents(__DIR__ . "/../database/questionOne.sql");
        $result = $this->db->query($query); 
        $row = 10; 

        while ($rs = $result->fetchArray()) {
            $this->assertEquals($rs[0], $row);
            $row++;
        }
    }     

    /**
     * Retrieve the owner's name, the car's make, and the car's model for all 
     * owners in their 50s using SQLite syntax.
     */
    public function testQTwo()
    {
        $query = file_get_contents(__DIR__ . "/../database/questionTwo.sql");
        $result = $this->db->query($query); 
        $this->assertEquals(3, $result->numColumns());
        $expectedColumns = array("name", "make", "model");
        
        foreach ($expectedColumns as $key => $value)
            $this->assertEquals($value, $result->columnName($key));

        $query = file_get_contents(
            __DIR__ . "/../database/test_questionTwo.sql"
        );

        $result = $this->db->query($query); 
       
        while ($rs = $result->fetchArray()) {
            $this->assertGreaterThanOrEqual(50, $rs['age']);
            $this->assertLessThan(60, $rs['age']);
        }
    }

    /**
     * Write an algorithm to add 1 to any integer values in an arbitrary depth 
     * array using php.
     */
    public function testQThree()
    {
        require_once(__DIR__ . "/../src/data.php");
        $clone = $data;
        incrementIntegerInArray($data);
        array_walk_recursive($clone, array($this, 'increment'));
        $this->assertEquals($clone, $data);
    }
    
    /**
     * Increment by 1 if value is an integer.
     */
    function increment(&$item, $key)
    {
        if (is_integer($item))
           $item++; 
    }

    /**
     * Write a function that receives a sorted indexed array(with no keys) of 
     * integers and an integer to locate using php. The function returns 'true' 
     * or 'false' depending on the integer's presence in the sorted array.  
     * Analyze the performance characteristics of your function(Hint: Big O 
     * notation might be good here)
     */
    public function testQFour()
    {
        $even = array(1, 2, 3, 5, 8, 13, 21, 34, 55, 89);
        $this->assertTrue(locate($even, 13));
        $odd = array(-10, -3, 1, 2.2, 3.3, 5, 8, 13, 21, 34, 55, 89, 144);
        $this->assertTrue(locate($odd, 144));
        $this->assertTrue(locate($odd, -10));

        $this->assertFalse(locate($even, 1000));
        $this->assertFalse(locate($odd, 1000));
    }
    
    /**
     * Test invalid input on sortedIntegerArray
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid Array
     */
    public function testQFourInvalidInputSortedIntegerArray()
    {
        locate(null, 123);
    }

    /**
     * Test invalid input on integerValue
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid Value
     */
    public function testQFourInvalidInputIntegerValue()
    {
        $even = array(1, 2, 3, 5, 8, 13, 21, 34, 55, 89);
        locate($even, null);
    }

    /**
     * Test regex for first instance of source IP on access log.
     *
     * Note: Primary concept is to return first instance of a matching IP 
     * address whos mask bit = 24 on an IP address 192.168.1.0
     */
    public function testQFive()
    {
        $log = file_get_contents(__DIR__ . "/../logs/logs.log");
        $base = '(?:192\.)(?:168\.)(?:1\.)';
        $chart = array(
             24 => "/\b{$base}(?:[01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\b/"
        );
        preg_match($chart[24], $log, $matches);
        $expectedIp = '192.168.1.126';
        $this->assertEquals($expectedIp, $matches[0]);
    }
}

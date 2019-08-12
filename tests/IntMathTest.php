<?php

/**
 * This file is part of the phpcommon/intmath package.
 *
 * (c) Marcos Passos <marcos@marcospassos.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace PhpCommon\IntMath\Tests;

use PhpCommon\IntMath\IntMath;
use PHPUnit\Framework\TestCase;

/**
 * @since  1.0
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 */
class IntMathTest extends TestCase
{
    public function getNonIntegerValues()
    {
        return array(
            array(1.0),
            array(\INF),
            array(-\INF),
            array(\NAN),
            array(null),
            array(true),
            array(false),
            array('a'),
            array(new \stdClass()),
            array(\curl_init()),
            array(array())
        );
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @testdox The negate() method throws an exception if the argument is not an integer
     */
    public function testNegateThrowsAnExceptionIfTheArgumentIsNotAnInteger($value)
    {
        $this->expectException('InvalidArgumentException');

        IntMath::negate($value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::negate
     *
     * @testdox The negate() method returns the given value with the opposite sign
     */
    public function testNegateReturnsTheArgumentWithOppositeSign()
    {
        $this->assertEquals(0, IntMath::negate(0));
        $this->assertEquals(0, IntMath::negate(-0));
        $this->assertEquals(-100, IntMath::negate(100));
        $this->assertEquals(100, IntMath::negate(-100));
        $this->assertEquals(-\PHP_INT_MIN, IntMath::negate(\PHP_INT_MIN));
        $this->assertEquals(\PHP_INT_MAX, IntMath::negate(-\PHP_INT_MAX));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::negate
     *
     * @testdox The negate() method does not negate the smallest negative integer
     */
    public function testNegateDoesNotNegateTheSmallestNegativeInteger()
    {
        $this->assertEquals(\PHP_INT_MIN, IntMath::negate(\PHP_INT_MIN));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::add
     *
     * * @testdox The add() method returns the sum of the arguments
     */
    public function testAddReturnsTheSumOfTheArguments()
    {
        $this->assertEquals(0, IntMath::add(0, 0));
        $this->assertEquals(1, IntMath::add(0, 1));
        $this->assertEquals(1, IntMath::add(1, 0));
        $this->assertEquals(0, IntMath::add(100, -100));
        $this->assertEquals(-2, IntMath::add(-1, -1));
        $this->assertEquals(4, IntMath::add(2, 2));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @testdox The add() method throws an exception if one of the arguments is not an integer
     */
    public function testAddThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        $this->expectException('InvalidArgumentException');

        IntMath::add($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::add
     *
     * @testdox The add() method wraps around the result on overflow
     */
    public function testAddWrapsAroundOnOverflow()
    {
        $this->assertEquals(\PHP_INT_MIN, IntMath::add(PHP_INT_MAX, 1));
        $this->assertEquals(\PHP_INT_MIN, IntMath::add(PHP_INT_MAX, -1));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @testdox The subtract() method throws an exception if one of the arguments is not an integer
     */
    public function testSubtractThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        $this->expectException('InvalidArgumentException');

        IntMath::subtract($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::subtract
     *
     * @testdox The subtract() method returns the difference of the arguments
     */
    public function testSubtractReturnsTheDifferenceOfTheArguments()
    {
        $this->assertEquals(0, IntMath::subtract(0, 0));
        $this->assertEquals(-1, IntMath::subtract(0, 1));
        $this->assertEquals(1, IntMath::subtract(1, 0));
        $this->assertEquals(200, IntMath::subtract(100, -100));
        $this->assertEquals(0, IntMath::subtract(-1, -1));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::subtract
     *
     * @testdox The subtract() method wraps around the result on overflow
     */
    public function testSubtractWrapsAroundOnOverflow()
    {
        $this->assertEquals(\PHP_INT_MAX, IntMath::subtract(\PHP_INT_MIN, 1));
        $this->assertEquals(\PHP_INT_MIN, IntMath::subtract(\PHP_INT_MAX, -1));
        $this->assertEquals(-1, IntMath::subtract(\PHP_INT_MAX, \PHP_INT_MIN));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @testdox The multiply() method throws an exception if one of the arguments is not an integer
     */
    public function testMultiplyThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        $this->expectException('InvalidArgumentException');

        IntMath::multiply($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::multiply
     *
     * @testdox The multiply() method returns the product of the arguments
     */
    public function testMultiplyReturnsTheProductOfTheArguments()
    {
        $this->assertEquals(0, IntMath::multiply(1, 0));
        $this->assertEquals(0, IntMath::multiply(0, 1));
        $this->assertEquals(-1, IntMath::multiply(1, -1));
        $this->assertEquals(-1, IntMath::multiply(-1, 1));
        $this->assertEquals(1, IntMath::multiply(1, 1));
        $this->assertEquals(-150, IntMath::multiply(-10, 15));
        $this->assertEquals(-150, IntMath::multiply(10, -15));
        $this->assertEquals(\PHP_INT_MAX, IntMath::multiply(1, \PHP_INT_MAX));
        $this->assertEquals(-\PHP_INT_MAX, IntMath::multiply(-1, \PHP_INT_MAX));
        $this->assertEquals(-\PHP_INT_MAX, IntMath::multiply(1, -\PHP_INT_MAX));
        $this->assertEquals(0, IntMath::multiply(0, \PHP_INT_MAX));
        $this->assertEquals(0, IntMath::multiply(0, -\PHP_INT_MAX));
        $this->assertEquals(\PHP_INT_MIN, IntMath::multiply(1, \PHP_INT_MIN));
        $this->assertEquals(0, IntMath::multiply(0, \PHP_INT_MIN));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::multiply
     *
     * @testdox The multiply() method wraps around the result on overflow
     */
    public function testMultiplyWrapsAroundOnOverflow()
    {
        $this->assertEquals(-2, IntMath::multiply(\PHP_INT_MAX, 2));
        $this->assertEquals(-2, IntMath::multiply(2, \PHP_INT_MAX));
        $this->assertEquals(2, IntMath::multiply(2, -\PHP_INT_MAX));
        $this->assertEquals(2, IntMath::multiply(-2, \PHP_INT_MAX));
        $this->assertEquals(\PHP_INT_MAX + -2, IntMath::multiply(\PHP_INT_MAX, 3));
        $this->assertEquals(\PHP_INT_MAX + -2, IntMath::multiply(3, \PHP_INT_MAX));
        $this->assertEquals(1, IntMath::multiply(\PHP_INT_MAX, \PHP_INT_MAX));
        $this->assertEquals(\PHP_INT_MIN, IntMath::multiply(\PHP_INT_MIN, 3));
        $this->assertEquals(\PHP_INT_MIN, IntMath::multiply(3, \PHP_INT_MIN));
        $this->assertEquals(\PHP_INT_MIN, IntMath::multiply(\PHP_INT_MIN, -3));
        $this->assertEquals(\PHP_INT_MIN, IntMath::multiply(-3, \PHP_INT_MIN));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @testdox The divide() method throws an exception if one of the arguments is not an integer
     */
    public function testDivideThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        $this->expectException('InvalidArgumentException');

        IntMath::divide($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::divide
     *
     * @testdox The divide() method returns the quotient of dividing one operand from another
     */
    public function testDivideReturnsTheQuotientOfTheArguments()
    {
        $this->assertEquals(1, IntMath::divide(1, 1));
        $this->assertEquals(0, IntMath::divide(0, 1));
        $this->assertEquals(-1, IntMath::divide(1, -1));
        $this->assertEquals(-1, IntMath::divide(-1, 1));
        $this->assertEquals(1, IntMath::divide(10, 10));
        $this->assertEquals(-2, IntMath::divide(-20, 10));
        $this->assertEquals(-2, IntMath::divide(20, -10));
        $this->assertEquals(1, IntMath::divide(\PHP_INT_MAX, \PHP_INT_MAX));
        $this->assertEquals(1, IntMath::divide(\PHP_INT_MIN, \PHP_INT_MIN));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::divide
     *
     * @testdox The divide() method rounds the result towards zero
     */
    public function testDivideRoundsTheResultTowardsZero()
    {
        $this->assertEquals(2, IntMath::divide(5, 2));
        $this->assertEquals(-2, IntMath::divide(-5, 2));
        $this->assertEquals(0, IntMath::divide(1, 2));
        $this->assertEquals(0, IntMath::divide(-1, 2));
        $this->assertEquals(0, IntMath::divide(1, \PHP_INT_MIN));
        $this->assertEquals(\PHP_INT_MIN, IntMath::divide(\PHP_INT_MIN, 1));
        $this->assertEquals(0, IntMath::divide(1, \PHP_INT_MAX));
        $this->assertEquals(\PHP_INT_MAX, IntMath::divide(\PHP_INT_MAX, 1));
    }

    /**
     * @testdox The divide() method throws an exception when a division by zero occurs
     */
    public function testDivideThrowsExceptionOnDivisionByZero()
    {
        $this->expectException('\PhpCommon\IntMath\DivisionByZeroException');

        IntMath::divide(1, 0);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::divide
     *
     * @testdox The divide() method returns the negative largest integer on overflow
     */
    public function testDivideReturnsTheNegativeLargestIntegerOnOverflow()
    {
        $this->assertEquals(\PHP_INT_MIN, IntMath::divide(\PHP_INT_MIN, -1));
    }
}

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
     * @expectedException \InvalidArgumentException
     *
     * @testdox The negate() method throws an exception if the argument is not an integer
     */
    public function testNegateThrowsAnExceptionIfTheArgumentIsNotAnInteger($value)
    {
        IntMath::negate($value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::negate
     *
     * @testdox The negate() method returns the given value with the opposite sign
     */
    public function testNegateReturnsTheArgumentWithOppositeSign()
    {
        $this->assertSame(0, IntMath::negate(0));
        $this->assertSame(0, IntMath::negate(-0));
        $this->assertSame(-100, IntMath::negate(100));
        $this->assertSame(100, IntMath::negate(-100));
        $this->assertSame(-\PHP_INT_MIN, IntMath::negate(\PHP_INT_MIN));
        $this->assertSame(\PHP_INT_MAX, IntMath::negate(-\PHP_INT_MAX));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::negate
     *
     * @testdox The negate() method does not negate the smallest negative integer
     */
    public function testNegateDoesNotNegateTheSmallestNegativeInteger()
    {
        $this->assertSame(\PHP_INT_MIN, IntMath::negate(\PHP_INT_MIN));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::add
     *
     * * @testdox The add() method returns the sum of the arguments
     */
    public function testAddReturnsTheSumOfTheArguments()
    {
        $this->assertSame(0, IntMath::add(0, 0));
        $this->assertSame(1, IntMath::add(0, 1));
        $this->assertSame(1, IntMath::add(1, 0));
        $this->assertSame(0, IntMath::add(100, -100));
        $this->assertSame(-2, IntMath::add(-1, -1));
        $this->assertSame(4, IntMath::add(2, 2));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @expectedException \InvalidArgumentException
     *
     * @testdox The add() method throws an exception if one of the arguments is not an integer
     */
    public function testAddThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        IntMath::add($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::add
     *
     * @testdox The add() method wraps around the result on overflow
     */
    public function testAddWrapsAroundOnOverflow()
    {
        $this->assertSame(\PHP_INT_MIN, IntMath::add(PHP_INT_MAX, 1));
        $this->assertSame(\PHP_INT_MIN, IntMath::add(PHP_INT_MAX, -1));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @expectedException \InvalidArgumentException
     *
     * @testdox The subtract() method throws an exception if one of the arguments is not an integer
     */
    public function testSubtractThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        IntMath::subtract($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::subtract
     *
     * @testdox The subtract() method returns the difference of the arguments
     */
    public function testSubtractReturnsTheDifferenceOfTheArguments()
    {
        $this->assertSame(0, IntMath::subtract(0, 0));
        $this->assertSame(-1, IntMath::subtract(0, 1));
        $this->assertSame(1, IntMath::subtract(1, 0));
        $this->assertSame(200, IntMath::subtract(100, -100));
        $this->assertSame(0, IntMath::subtract(-1, -1));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::subtract
     *
     * @testdox The subtract() method wraps around the result on overflow
     */
    public function testSubtractWrapsAroundOnOverflow()
    {
        $this->assertSame(\PHP_INT_MAX, IntMath::subtract(\PHP_INT_MIN, 1));
        $this->assertSame(\PHP_INT_MIN, IntMath::subtract(\PHP_INT_MAX, -1));
        $this->assertSame(-1, IntMath::subtract(\PHP_INT_MAX, \PHP_INT_MIN));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @expectedException \InvalidArgumentException
     *
     * @testdox The multiply() method throws an exception if one of the arguments is not an integer
     */
    public function testMultiplyThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        IntMath::multiply($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::multiply
     *
     * @testdox The multiply() method returns the product of the arguments
     */
    public function testMultiplyReturnsTheProductOfTheArguments()
    {
        $this->assertSame(0, IntMath::multiply(1, 0));
        $this->assertSame(0, IntMath::multiply(0, 1));
        $this->assertSame(-1, IntMath::multiply(1, -1));
        $this->assertSame(-1, IntMath::multiply(-1, 1));
        $this->assertSame(1, IntMath::multiply(1, 1));
        $this->assertSame(-150, IntMath::multiply(-10, 15));
        $this->assertSame(-150, IntMath::multiply(10, -15));
        $this->assertSame(\PHP_INT_MAX, IntMath::multiply(1, \PHP_INT_MAX));
        $this->assertSame(-\PHP_INT_MAX, IntMath::multiply(-1, \PHP_INT_MAX));
        $this->assertSame(-\PHP_INT_MAX, IntMath::multiply(1, -\PHP_INT_MAX));
        $this->assertSame(0, IntMath::multiply(0, \PHP_INT_MAX));
        $this->assertSame(0, IntMath::multiply(0, -\PHP_INT_MAX));
        $this->assertSame(\PHP_INT_MIN, IntMath::multiply(1, \PHP_INT_MIN));
        $this->assertSame(0, IntMath::multiply(0, \PHP_INT_MIN));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::multiply
     *
     * @testdox The multiply() method wraps around the result on overflow
     */
    public function testMultiplyWrapsAroundOnOverflow()
    {
        $this->assertSame(-2, IntMath::multiply(\PHP_INT_MAX, 2));
        $this->assertSame(-2, IntMath::multiply(2, \PHP_INT_MAX));
        $this->assertSame(2, IntMath::multiply(2, -\PHP_INT_MAX));
        $this->assertSame(2, IntMath::multiply(-2, \PHP_INT_MAX));
        $this->assertSame(\PHP_INT_MAX + -2, IntMath::multiply(\PHP_INT_MAX, 3));
        $this->assertSame(\PHP_INT_MAX + -2, IntMath::multiply(3, \PHP_INT_MAX));
        $this->assertSame(1, IntMath::multiply(\PHP_INT_MAX, \PHP_INT_MAX));
        $this->assertSame(\PHP_INT_MIN, IntMath::multiply(\PHP_INT_MIN, 3));
        $this->assertSame(\PHP_INT_MIN, IntMath::multiply(3, \PHP_INT_MIN));
        $this->assertSame(\PHP_INT_MIN, IntMath::multiply(\PHP_INT_MIN, -3));
        $this->assertSame(\PHP_INT_MIN, IntMath::multiply(-3, \PHP_INT_MIN));
    }

    /**
     * @param mixed $value
     *
     * @dataProvider getNonIntegerValues
     *
     * @expectedException \InvalidArgumentException
     *
     * @testdox The divide() method throws an exception if one of the arguments is not an integer
     */
    public function testDivideThrowsAnExceptionIfOneOfTheArgumentIsNotAnInteger($value)
    {
        IntMath::divide($value, $value);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::divide
     *
     * @testdox The divide() method returns the quotient of dividing one operand from another
     */
    public function testDivideReturnsTheQuotientOfTheArguments()
    {
        $this->assertSame(1, IntMath::divide(1, 1));
        $this->assertSame(0, IntMath::divide(0, 1));
        $this->assertSame(-1, IntMath::divide(1, -1));
        $this->assertSame(-1, IntMath::divide(-1, 1));
        $this->assertSame(1, IntMath::divide(10, 10));
        $this->assertSame(-2, IntMath::divide(-20, 10));
        $this->assertSame(-2, IntMath::divide(20, -10));
        $this->assertSame(1, IntMath::divide(\PHP_INT_MAX, \PHP_INT_MAX));
        $this->assertSame(1, IntMath::divide(\PHP_INT_MIN, \PHP_INT_MIN));
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::divide
     *
     * @testdox The divide() method rounds the result towards zero
     */
    public function testDivideRoundsTheResultTowardsZero()
    {
        $this->assertSame(2, IntMath::divide(5, 2));
        $this->assertSame(-2, IntMath::divide(-5, 2));
        $this->assertSame(0, IntMath::divide(1, 2));
        $this->assertSame(0, IntMath::divide(-1, 2));
        $this->assertSame(0, IntMath::divide(1, \PHP_INT_MIN));
        $this->assertSame(\PHP_INT_MIN, IntMath::divide(\PHP_INT_MIN, 1));
        $this->assertSame(0, IntMath::divide(1, \PHP_INT_MAX));
        $this->assertSame(\PHP_INT_MAX, IntMath::divide(\PHP_INT_MAX, 1));
    }

    /**
     * @testdox The divide() method throws an exception when a division by zero occurs
     *
     * @expectedException \InvalidArgumentException
     */
    public function testDivideThrowsExceptionOnDivisionByZero()
    {
        IntMath::divide(1, 0);
    }

    /**
     * @covers \PhpCommon\IntMath\IntMath::divide
     *
     * @testdox The divide() method returns the negative largest integer on overflow
     */
    public function testDivideReturnsTheNegativeLargestIntegerOnOverflow()
    {
        $this->assertSame(\PHP_INT_MIN, IntMath::divide(\PHP_INT_MIN, -1));
    }
}

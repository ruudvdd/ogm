<?php
namespace Ruudvdd\OGM;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Validator
     */
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function testOGMWithMixedEndAndStartSignsReturnsFalse()
    {
        // The numbers and slashes are correct, but the signs at the beginning and the end are mixed
        $this->assertEquals(false, $this->validator->isValid('+++623/5790/50505***'));
    }

    public function testOGMWithCorrectStructureButWrongNumbersReturnsFalse()
    {
        // The signs at the beginning and end and slashes are correct, but the control number is wrong
        $this->assertEquals(false, $this->validator->isValid('+++623/5790/50506+++'));
    }

    public function testOGMWithCorrectOGMWithAsterisksReturnsTrue()
    {
        // everything is correct
        $this->assertEquals(true, $this->validator->isValid('+++623/5790/50505+++'));
    }

    public function testCorrectNumberOfDigitsAndControlDigitsAreValid()
    {
        $this->assertEquals(true, $this->validator->digitsAreValid('623579050505'));
    }

    public function testIncorrectNumberOfDigitsButValidControlDigitsReturnsFalse()
    {
        // the digits would be correct if the length doesn't matter
        $this->assertEquals(false, $this->validator->digitsAreValid('1623579050554'));
    }

    public function testOGMWithLeadingZeroIsValid()
    {
        /*
         * The OGM is correct, but it's possible my validator can not handle
         * OGMs with one or more leading zero's
         */
        $this->assertEquals(true, $this->validator->isValid('+++045/5372/71911+++'));
    }
}

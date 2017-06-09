<?php
namespace Ruudvdd\OGM;

use Ruudvdd\OGM\Exception\TooMuchDigits;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Generator
     */
    protected $generator;

    /**
     * @var Validator
     */
    protected $validator;

    public function setUp()
    {
        $this->generator = new Generator();
        /*
         * I'm going to use the validator to validate my generated OGMs. Because I've tested
         * my Validator in ValidatorTest.php I'm confident I can use it freely
         */
        $this->validator = new Validator();
    }

    public function testGeneratorGeneratesAValidNonFormattedDigit()
    {
        // test this 100 times
        for ($i = 0; $i < 100; ++$i) {
            $digit = $this->generator->generate();
            $this->assertEquals(
                true,
                $this->validator->digitsAreValid($digit),
                sprintf('Digit %s failed the test', $digit)
            );
        }
    }

    public function testGeneratorGeneratesAValidFormattedDigit()
    {
        // test this 100 times
        for ($i = 0; $i < 100; ++$i) {
            $ogm = $this->generator->generate(true);
            $this->assertEquals(
                true,
                $this->validator->isValid($ogm),
                sprintf('OGM %s failed the test', $ogm)
            );
        }
    }

    public function testGeneratorGeneratesAValidFormattedDigitWithPrefix()
    {
        $prefix = 12345;
        $digits = $this->generator->generate(false, $prefix);
        $this->assertStringStartsWith('' . $prefix, $digits);
        $this->assertEquals(true, $this->validator->digitsAreValid((int) $digits));
    }

    public function testGeneratorThrowsExceptionWhenPassedMoreThan10Digits()
    {
        $this->expectException(TooMuchDigits::class);
        $prefix = 12345123456;
        $this->generator->generate(false, $prefix);
    }
}

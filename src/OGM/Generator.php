<?php
namespace OGM;

use OGM\Exception\TooMuchDigits;

class Generator
{
    /**
     * @param bool $formatted
     * @param int|string|null $prefix
     * @return string
     */
    public function generate($formatted = false, $prefix = null)
    {
        $this->guardInputType($prefix);
        $this->guardTooMuchDigits($prefix);

        if ($prefix === null) {
            $prefix = '';
        }
        $digitsToFill = 10 - strlen('' . $prefix);
        $digitsWithoutControl = $prefix . $this->generateRandomDigit($digitsToFill);
        $digitWithControl = $digitsWithoutControl . $this->generateControlDigits($digitsWithoutControl);

        if (!$formatted) {
            return $digitWithControl;
        }

        return $this->format($digitWithControl);
    }

    /**
     * @param int|string|null $digits
     */
    private function guardInputType($digits)
    {
        if (!is_string($digits) && !is_int($digits) && $digits !== null) {
            throw new \InvalidArgumentException('Digits must be a string, int or null');
        }
    }

    /**
     * @param int|string|null $digits
     */
    private function guardTooMuchDigits($digits)
    {
        if ($digits !== null && strlen('' . $digits) > 10) {
            throw new TooMuchDigits('You can\'t provide more than 10 digits to generate an OGM');
        }
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomDigit($length)
    {
        $digit = '';
        for ($digits = 0; $digits < $length; ++$digits) {
            $digit .= mt_rand(0, 9);
        }

        return $digit;
    }

    /**
     * @param int $digits
     * @return int
     */
    private function generateControlDigits($digits)
    {
        $rest = $digits % 97;

        if ($rest === 0) {
            $rest = 97;
        }

        return sprintf('%02d', $rest);
    }

    /**
     * @param int $digitWithControl
     * @return string
     */
    private function format($digitWithControl)
    {
        return sprintf(
            '+++%s/%s/%s+++',
            substr($digitWithControl, 0, 3),
            substr($digitWithControl, 3, 4),
            substr($digitWithControl, 7, 5)
        );
    }
}

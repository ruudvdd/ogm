<?php
namespace Ruudvdd\OGM;

class Validator
{
    /**
     * Check if the structured string is a valid OGM. Pass the ogm with the +++ or *** signs and the slashes
     *
     * @param string $ogm
     * @return bool
     */
    public function isValid($ogm)
    {
        if (!$this->structureIsValid($ogm, $matches)) {
            return false;
        }

        list(, $firstGroup, $secondGroup, $thirdGroup) = $matches;

        $number = $firstGroup . $secondGroup . $thirdGroup;

        if (!$this->digitsAreValid($number)) {
            return false;
        }

        return true;
    }

    /**
     * Check if the digits without the slashes and +++'s or ***'s are valid
     *
     * @param string $number
     * @return bool
     */
    public function digitsAreValid($number)
    {
        if (strlen($number) !== 12) {
            return false;
        }

        $divided = (int)substr('' . $number, 0, -2);
        $controlNumber = (int)substr('' . $number, -2);

        $rest = $divided % 97;

        if ($rest === 0) {
            $rest = 97;
        }

        return $rest === $controlNumber;
    }

    /**
     * @param string $ogm
     * @param array $matches $contains the whole match and the 3 digit groups
     * @return bool
     */
    private function structureIsValid($ogm, &$matches)
    {
        $ogm = str_replace('+++', '***', $ogm, $count);

        if ($count !== 2) {
            return false;
        }

        $hasMatch = preg_match('/^\*{3}(\d{3})\/(\d{4})\/(\d{5})\*{3}$/', $ogm, $matches);

        if (!$hasMatch) {
            return false;
        }

        return true;
    }
}

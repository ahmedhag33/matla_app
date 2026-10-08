<?php

namespace App\Service\Secure;

class PasswordGenerator
{
    // Alphabetic letters, lowercase
    const LETTERS = 'abcdefghijklmnopqrstuvwxyz';
    // Digits
    const DIGITS = '0123456789';
    // Special characters
    const SPECIAL_CHARS = '!@#$%^&*()_+-={}[]|:;"<>,.?/';
    // The maximum similarity percentage
    const MAX_SIMILARITY_PERC = 20;
    /**
     * The password minimum length
     *
     * @var mixed
     */
    private $minLength;
    /**
     * The password maximum length
     *
     * @var mixed
     */
    private $maxLength;
    /**
     * The optional list of strings that must be different from the password
     *
     * @var mixed
     */
    private $diffStrings;
    /**
     * Method __construct
     *
     * @param int $minLength
     * @param int $maxLength
     * @param array $diffStrings
     *
     * @return void
     */
    public function __construct(int $minLength = 4, int $maxLength = 32, array $diffStrings = [])
    {
        $this->minLength = $minLength;

        $this->maxLength = $maxLength;

        $this->diffStrings = $diffStrings;
    }
    /**
     * create the password
     *
     * @return string
     */
    public function generate()
    {
        // List of usable characters
        $chars = self::LETTERS . mb_strtoupper(self::LETTERS) . self::DIGITS . self::SPECIAL_CHARS;
        // Flag to check if the password is ready
        $passwordReady = false;
        // Loop until a valid password is generated
        while (!$passwordReady) {
            $password = '';
            // Flags to check if the password contains at least one character of each type
            $hasLowercase = false;
            // Flag to check if the password contains at least one uppercase letter
            $hasUppercase = false;
            // Flag to check if the password contains at least one digit
            $hasDigit = false;
            // Flag to check if the password contains at least one special character
            $hasSpecialChar = false;
            // Generate a random password length between the minimum and maximum
            $length = random_int($this->minLength, $this->maxLength);
            // Generate the password character by character
            while ($length > 0) {
                $length--;
                // Select a random character from the list of usable characters
                $index = random_int(0, mb_strlen($chars) - 1);
                // Get the character at the selected index
                $char = $chars[$index];
                // Append the character to the password
                $password .= $char;
                // Update the flags based on the type of the character
                $hasLowercase = $hasLowercase || (mb_strpos(self::LETTERS, $char) !== false);
                // Update the flag for uppercase letters
                $hasUppercase = $hasUppercase || (mb_strpos(mb_strtoupper(self::LETTERS), $char) !== false);
                // Update the flag for digits
                $hasDigit = $hasDigit || (mb_strpos(self::DIGITS, $char) !== false);
                // Update the flag for special characters
                $hasSpecialChar = $hasSpecialChar || (mb_strpos(self::SPECIAL_CHARS, $char) !== false);
            }
            $passwordReady = ($hasLowercase && $hasUppercase && $hasDigit && $hasSpecialChar);
            // If the password meets the character type requirements, check its similarity with the provided strings
            if ($passwordReady) {
                foreach ($this->diffStrings as $string) {
                    similar_text($password, $string, $similarityPerc);
                    // If the similarity percentage is greater than or equal to the maximum allowed, the password is not ready
                    $passwordReady = $passwordReady && ($similarityPerc < self::MAX_SIMILARITY_PERC);
                }
            }
        }
        return $password;
    }
}

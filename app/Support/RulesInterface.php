<?php

namespace App\Support;

interface RulesInterface
{
    /**
     * Get the validation rules for a specific step.
     *
     * @param int $step
     * @return array
     */
    public static function step(int $step): array;
     /**
     * Get all the validation rules.
     *
     * @return array
     */
    public static function all(): array;
    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public static function messages(): array;
}

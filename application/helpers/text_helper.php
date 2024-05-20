<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('slugify')) {
    /**
     * Generate a slugified version of a string that can be used as part of a url
     *
     * Example:
     *
     * $slug = slugify('kemi smile'); // Returns "kemi_smile"
     *
     * @param string $text
     *
     * @return string
     */
    function slugify(string $text = ''): string
    {
        if (empty($text)) {
            return '';
        }
        // Lowercase the text
        $text = strtolower($text);

        // Replace accented characters (if iconv extension is available)
        if (function_exists('iconv')) {
            $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        }

        // Replace spaces and non-word characters with hyphens
        $text = preg_replace('/\W+/', '_', $text);

        // Remove leading and trailing hyphens
        $text = trim($text, '-');

        return $text;
    }
}


if (!function_exists('insert_after_char')) {
    function insert_after_char($text, $insertion, $char)
    {
        // Validate input types
        if (!is_string($text) || !is_string($insertion) || !is_string($char)) {
            throw new TypeError("All arguments must be strings");
        }

        $pos = strpos($text, $char);
        if ($pos === false) {
            throw new ValueError("Character '$char' not found in the string");
        }

        return substr($text, 0, $pos) . $insertion . $char . substr($text, $pos + 1);
    }
}

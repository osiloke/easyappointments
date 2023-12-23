<?php defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2020, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.4.0
 * ---------------------------------------------------------------------------- */

if (!function_exists('is_assoc')) {
    /**
     * Check if an array is an associative array.
     *
     * @param array $array
     *
     * @return bool
     */
    function is_assoc(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if (!function_exists('array_find')) {
    /**
     * Find the first array element based on the provided function.
     *
     * @param array $array
     * @param callable $callback
     *
     * @return mixed
     */
    function array_find(array $array, callable $callback): mixed
    {
        if (empty($array)) {
            return null;
        }

        if (!is_callable($callback)) {
            throw new InvalidArgumentException('No filter function provided.');
        }

        return array_filter($array, $callback)[0] ?? null;
    }
}

if (!function_exists('array_fields')) {
    /**
     * Keep only the provided fields of an array.
     *
     * @param array $array
     * @param array $fields
     *
     * @return array
     */
    function array_fields(array $array, array $fields): array
    {
        return array_filter(
            $array,
            function ($field) use ($fields) {
                return in_array($field, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}

/**
 * Sanitize the description field of an array of items.
 *
 * @param array $items
 * @param array $fields
 *
 * @return array
 */
// Define a function that takes an array of items and an array of fields and returns a new array with tags stripped from the fields
// Define a function that takes an array of items and an array of fields and returns a new array with tags stripped from the fields
function sanitize_fields(array $items, array $fields): array
{
    // Check if either of the parameters is empty
    if (empty($items) || empty($fields)) {
        // Return the original items array
        return $items;
    }
    // Create an empty array to store the new items
    $new_items = [];
    // Loop through each item in the original array
    foreach ($items as $item) {
        // Copy the item to a new variable
        $new_item = $item;
        // Loop through each field in the fields array
        foreach ($fields as $field) {
            // Strip tags from the field using the built-in strip_tags function
            // You can change the allowed tags as per your requirement
            $new_item[$field] = strip_tags($item[$field], '<p><br><b><strong><em><u><ol><ul><li>');
        }
        // Add the new item to the new array
        $new_items[] = $new_item;
    }
    // Return the new array of items
    return $new_items;
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('price_from_duration')) {
    /**
     * Calculate price from duration.
     *
     * Example:
     *
     * @param string $start
     * @param string $end
     * @param int $duration
     * @param int $price
     *
     * @return int
     */
    function price_from_duration(string $start, string $end, int $service_duration, float $price): int
    {
        $start = new DateTime($start);
        $end = new DateTime($end);

        // Calculate duration between start and end
        $interval = $end->diff($start);
        $duration = $interval->days * 24 * 60;
        $duration += $interval->h * 60;
        $duration += $interval->i;

        // Divide by service duration
        $result = $duration / $service_duration;
        $amount = $result * $price;

        return $amount;
    }
    /**
     * Calculate fee from duration.
     *
     *
     * @param string $start
     * @param string $end
     * @param int $duration
     * @param int $price
     *
     * @return int
     */
    function fee_from_duration(string $start, string $end, int $service_duration, float $fee): float
    {
        $start = new DateTime($start);
        $end = new DateTime($end);

        // Calculate duration between start and end
        $interval = $end->diff($start);
        $duration = $interval->days * 24 * 60;
        $duration += $interval->h * 60;
        $duration += $interval->i;

        // Divide by service duration
        $result = $duration / $service_duration;
        $amount = $result * $fee;

        return $amount;
    }
}

<?php

namespace App\Helpers;

/**
 * Helper functions for Air Quality Index (AQI) related operations
 */
class AqiHelper
{
    /**
     * Get the appropriate color class based on AQI value
     *
     * @param int $aqi Air Quality Index value
     * @return string CSS color class name
     */
    public static function getAqiColorClass($aqi)
    {
        if ($aqi <= 50) {
            return 'success'; // Good - Green
        } elseif ($aqi <= 100) {
            return 'warning'; // Moderate - Yellow
        } elseif ($aqi <= 150) {
            return 'warning-600'; // Unhealthy for Sensitive Groups - Orange
        } elseif ($aqi <= 200) {
            return 'danger'; // Unhealthy - Red
        } elseif ($aqi <= 300) {
            return 'purple-600'; // Very Unhealthy - Purple
        } else {
            return 'danger-800'; // Hazardous - Maroon
        }
    }

    /**
     * Get the AQI status description based on AQI value
     *
     * @param int $aqi Air Quality Index value
     * @return string Status description
     */
    public static function getAqiStatus($aqi)
    {
        if ($aqi <= 50) {
            return 'Good';
        } elseif ($aqi <= 100) {
            return 'Moderate';
        } elseif ($aqi <= 150) {
            return 'Unhealthy for Sensitive Groups';
        } elseif ($aqi <= 200) {
            return 'Unhealthy';
        } elseif ($aqi <= 300) {
            return 'Very Unhealthy';
        } else {
            return 'Hazardous';
        }
    }
}

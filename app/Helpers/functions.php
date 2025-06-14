<?php

use App\Helpers\AqiHelper;

/**
 * Global helper functions for the Air Quality Dashboard
 */

if (!function_exists('getAqiColorClass')) {
    /**
     * Get the appropriate color class based on AQI value
     *
     * @param int $aqi Air Quality Index value
     * @return string CSS color class name
     */
    function getAqiColorClass($aqi) {
        if ($aqi <= 50) return 'success';
        if ($aqi <= 100) return 'warning';
        if ($aqi <= 150) return 'warning';
        if ($aqi <= 200) return 'danger';
        if ($aqi <= 300) return 'danger';
        return 'danger';
    }
}

if (!function_exists('getAqiColor')) {
    /**
     * Get the AQI color hex code based on AQI value
     *
     * @param int $aqi Air Quality Index value
     * @return string Hex color code
     */
    function getAqiColor($aqi) {
        if ($aqi <= 50) return '#00e400';
        if ($aqi <= 100) return '#ffff00';
        if ($aqi <= 150) return '#ff7e00';
        if ($aqi <= 200) return '#ff0000';
        if ($aqi <= 300) return '#99004c';
        return '#7e0023';
    }
}

if (!function_exists('getAqiStatus')) {
    /**
     * Get the AQI status description based on AQI value
     *
     * @param int $aqi Air Quality Index value
     * @return string Status description
     */
    function getAqiStatus($aqi)
    {
        return \App\Helpers\AqiHelper::getAqiStatus($aqi);
    }
}

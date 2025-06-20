<?php

if (!function_exists('getAqiColorClass')) {
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
    function getAqiColor($aqi) {
        if ($aqi <= 50) return '#00e400';
        if ($aqi <= 100) return '#ffff00';
        if ($aqi <= 150) return '#ff7e00';
        if ($aqi <= 200) return '#ff0000';
        if ($aqi <= 300) return '#99004c';
        return '#7e0023';
    }
}

import './bootstrap';
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import Chart from 'chart.js/auto';

// Make Leaflet and Chart.js available globally
window.L = L;
window.Chart = Chart;

// Sensor locations in Colombo
const sensorLocations = [
    { name: 'Fort', coords: [6.9271, 79.8612] },
    { name: 'Bambalapitiya', coords: [6.8913, 79.8567] },
    { name: 'Borella', coords: [6.9144, 79.8769] },
    { name: 'Pettah', coords: [6.9367, 79.8507] },
    { name: 'Kollupitiya', coords: [6.9172, 79.8487] }
];

// Initialize Leaflet map when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Check if map container exists before initializing
    const mapElement = document.getElementById('map');
    if (mapElement) {
        // Initialize the map centered on Colombo
        const map = L.map('map').setView([6.9271, 79.8612], 13);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Initialize charts if available
        initChart();

        // If we have real sensor data from the server
        if (window.sensors && window.sensors.length) {
            displaySensors(map, window.sensors);
        } else {
            // Use predefined locations with random data
            displayPredefinedSensors(map);
        }
    }
});

// Function to fetch sensors and add them to the map
function fetchSensors(map) {
    // Check if sensors data is available in the window object (passed from blade template)
    if (window.sensors) {
        displaySensors(map, window.sensors);
        return;
    }

    // If not available in the window, fetch from API
    fetch('/api/sensors')
        .then(response => response.json())
        .then(data => {
            displaySensors(map, data);
        })
        .catch(error => {
            console.error('Error fetching sensors:', error);
        });
}

// Function to display sensors on the map
function displaySensors(map, sensors) {
    sensors.forEach(sensor => {
        if (!sensor.latitude || !sensor.longitude) return;

        // Determine color based on AQI if available
        let aqi = sensor.latest_reading ? sensor.latest_reading.aqi : 0;
        let color = getAQIColor(aqi);
        let radius = 500; // 500 meters radius

        // Create circle marker
        const circle = L.circle([sensor.latitude, sensor.longitude], {
            color: color,
            fillColor: color,
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);

        // Create popup content
        let popupContent = `
            <div>
                <h5>${sensor.name}</h5>
                <p>${sensor.location_name || sensor.location || ''}</p>
        `;

        if (sensor.latest_reading) {
            popupContent += `
                <div class="text-center">
                    <h3>${sensor.latest_reading.aqi}</h3>
                    <p>${getAQIStatus(sensor.latest_reading.aqi)}</p>
                    <p>PM2.5: ${sensor.latest_reading.pm25} μg/m³</p>
                    <p>PM10: ${sensor.latest_reading.pm10} μg/m³</p>
                </div>
                <a href="/sensor/${sensor.id}" class="btn btn-sm btn-primary">View Details</a>
            `;
        } else {
            popupContent += `<p>No readings available</p>`;
        }

        popupContent += `</div>`;

        // Bind popup to marker
        circle.bindPopup(popupContent);

        // Add click handler for info panel update
        circle.on('click', () => {
            updateInfoPanel(
                sensor.name,
                sensor.latest_reading ? sensor.latest_reading.aqi : 0,
                sensor.latest_reading ? sensor.latest_reading.pm25 : 0,
                sensor.latest_reading ? sensor.latest_reading.pm10 : 0
            );
        });
    });
}

// Display predefined sensor locations with random data
function displayPredefinedSensors(map) {
    // Add markers for each sensor location
    sensorLocations.forEach(location => {
        const aqi = generateRandomAQI();
        const circle = L.circle(location.coords, {
            color: getAQIColor(aqi),
            fillColor: getAQIColor(aqi),
            fillOpacity: 0.7,
            radius: 500
        }).addTo(map);

        // Add popup with location info
        circle.bindPopup(`
            <strong>${location.name}</strong><br>
            AQI: ${aqi}<br>
            Status: ${getAQIStatus(aqi)}
        `);

        // Add click handler
        circle.on('click', () => {
            updateInfoPanel(location.name, aqi);
        });
    });

    // Simulate real-time updates
    setInterval(() => {
        const mapLayers = [];
        map.eachLayer(layer => {
            if (layer instanceof L.Circle) {
                mapLayers.push(layer);
            }
        });

        sensorLocations.forEach((location, index) => {
            if (index < mapLayers.length - 1) { // -1 to exclude the tile layer
                const aqi = generateRandomAQI();
                const circle = mapLayers[index + 1]; // +1 to skip the tile layer

                circle.setStyle({
                    color: getAQIColor(aqi),
                    fillColor: getAQIColor(aqi)
                });

                circle.setPopupContent(`
                    <strong>${location.name}</strong><br>
                    AQI: ${aqi}<br>
                    Status: ${getAQIStatus(aqi)}
                `);

                // Update info panel if this location is currently selected
                if (document.getElementById('selected-location').textContent === location.name) {
                    updateInfoPanel(location.name, aqi);
                }
            }
        });
    }, 30000); // Update every 30 seconds
}

// Helper function to determine color based on AQI value
function getAQIColor(aqi) {
    if (aqi <= 50) return '#00e400'; // Good - Green
    if (aqi <= 100) return '#ffff00'; // Moderate - Yellow
    if (aqi <= 150) return '#ff7e00'; // Unhealthy for Sensitive Groups - Orange
    if (aqi <= 200) return '#ff0000'; // Unhealthy - Red
    if (aqi <= 300) return '#99004c'; // Very Unhealthy - Purple
    return '#7e0023'; // Hazardous - Maroon
}

// For backward compatibility with existing code
function getAqiColor(aqi) {
    return getAQIColor(aqi);
}

function getAQIStatus(aqi) {
    if (aqi <= 50) return 'Good';
    if (aqi <= 100) return 'Moderate';
    if (aqi <= 150) return 'Unhealthy for Sensitive Groups';
    if (aqi <= 200) return 'Unhealthy';
    if (aqi <= 300) return 'Very Unhealthy';
    return 'Hazardous';
}

// Generate random AQI data
function generateRandomAQI() {
    return Math.floor(Math.random() * 150) + 50; // Random AQI between 50 and 200
}

// Initialize chart
function initChart() {
    const chartElement = document.getElementById('trendChart');
    if (!chartElement) return;

    const ctx = chartElement.getContext('2d');
    const trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'AQI',
                data: [],
                borderColor: '#3498db',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 300
                }
            }
        }
    });

    // Store chart instance globally
    window.trendChart = trendChart;
}

// Update info panel with selected location data
function updateInfoPanel(locationName, aqi, pm25 = null, pm10 = null) {
    document.getElementById('selected-location').textContent = locationName;
    document.getElementById('aqi-value').textContent = aqi;
    document.getElementById('aqi-status').textContent = getAQIStatus(aqi);

    // Generate random PM2.5 and PM10 values if not provided
    const pm25Value = pm25 !== null ? pm25 : Math.floor(aqi * 0.8);
    const pm10Value = pm10 !== null ? pm10 : Math.floor(aqi * 1.5);

    document.getElementById('pm25-value').textContent = `${pm25Value} µg/m³`;
    document.getElementById('pm10-value').textContent = `${pm10Value} µg/m³`;

    // Update chart
    updateTrendChart(aqi);
}

// Update trend chart with new data point
function updateTrendChart(newAQI) {
    if (!window.trendChart) return;

    const now = new Date();
    const label = now.toLocaleTimeString();

    window.trendChart.data.labels.push(label);
    window.trendChart.data.datasets[0].data.push(newAQI);

    // Keep only last 24 data points
    if (window.trendChart.data.labels.length > 24) {
        window.trendChart.data.labels.shift();
        window.trendChart.data.datasets[0].data.shift();
    }

    window.trendChart.update();
}

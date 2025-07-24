document.addEventListener("DOMContentLoaded", function () {
    fetchChartData(7); // Load initial data for "This Week"
    fetchAverageData();
    updateLatestReading();

    document.getElementById('timePeriodSelect').addEventListener('change', function () {
        fetchChartData(this.value);
    });

    const toggleBtn = document.getElementById("darkModeToggle");
    const icon = document.getElementById("darkModeIcon");
    const body = document.body;
    
    const isDark = localStorage.getItem("darkMode") === "enabled" || (localStorage.getItem("darkMode") === null && window.matchMedia('(prefers-color-scheme: dark)').matches);
    applyDarkMode(isDark);

    toggleBtn.addEventListener("click", () => {
        const currentlyDark = body.classList.contains("dark-mode");
        localStorage.setItem("darkMode", currentlyDark ? "disabled" : "enabled");
        applyDarkMode(!currentlyDark);
    });
});

function fetchChartData(days) {
    fetch(`../backend_control/get_chart_data.php?days=${days}`)
        .then(response => response.json())
        .then(data => {
            if (!data || !Array.isArray(data.labels) || data.labels.length === 0) {
                displayNoDataMessage();
            } else {
                hideNoDataMessage(() => {
                    updateChart(data.labels, data.values);
                });
            }
        })
        .catch(error => {
            console.error("Error fetching chart data:", error);
            displayNoDataMessage();
        });
}

function displayNoDataMessage() {
    const container = document.querySelector('.chart-container');
    container.innerHTML = '<div class="text-center text-muted py-5">No data available for this period.</div>';
    if (chart) chart.destroy();
}

function hideNoDataMessage(callback) {
    const container = document.querySelector('.chart-container');
    container.innerHTML = '<canvas id="bloodSugarChart"></canvas>';
    requestAnimationFrame(callback);
}

let chart;
function updateChart(labels, values) {
    const ctx = document.getElementById('bloodSugarChart').getContext('2d');
    if (chart) chart.destroy();

    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Blood Sugar (mg/dL)',
                data: values,
                fill: false,
                borderColor: '#007bff',
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: false }
            }
        }
    });
}

function fetchAverageData() {
    fetch("../backend_control/get_7day_avg.php")
        .then(res => res.json())
        .then(data => {
            const avg = data.avg_value !== null ? parseFloat(data.avg_value).toFixed(1) : '--';
            document.getElementById("avg7Display").innerHTML = `${avg} <span class="fs-6">mg/dL</span>`;

            const trendContainer = document.getElementById("trendText");
            trendContainer.className = `${data.trend_class} small`;
            trendContainer.innerHTML = `<i class="bi ${data.trend_icon}"></i> ${data.trend_text}`;
        })
        .catch(err => {
            console.error("Failed to fetch 7-day average:", err);
        });
}

function updateLatestReading() {
    fetch("../backend_control/get_latest_reading.php")
        .then(res => res.json())
        .then(data => {
            console.log("Latest reading response:", data);
            const display = document.getElementById("currentLevelDisplay");

            if (!data || !data.original_value) {
                display.innerHTML = "<p class='text-muted'>No readings yet.</p>";
                return;
            }

            const html = `
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-uppercase text-muted small fw-bold">Current Level</h6>
                        <p class="card-value text-primary mb-1">${data.original_value} <span class="fs-6">${data.original_unit}</span></p>
                        <span class="fs-6"><small class="text-muted"><strong>Value in:</strong> ${data.converted_value}</small> ${data.converted_unit}</span>
                        <br>
                        <span class="badge bg-warning mt-2">${data.condition_status || '--'}</span>
                        <small class="text-muted">${new Date(data.converted_at).toLocaleString()}</small>
                    </div>
                    ${data.type ? `<span class="badge bg-info status-badge">${data.type.replace('_', ' ')}</span>` : ''}
                </div>
            `;

            display.innerHTML = html;
        })
        .catch(err => {
            console.error("Error loading latest reading:", err);
        });
}

function toggleRecurrenceFields() {
    const recurrence = document.getElementById('recurrenceSelect').value;
    const dayField = document.getElementById('weeklyDay');
    const timeField = document.getElementById('timeField');
    const dateField = document.getElementById('dateField');

    if (recurrence === 'weekly') {
        dayField.classList.remove('d-none');
        timeField.classList.remove('d-none');
        dateField.classList.add('d-none');
    } else if (recurrence === 'daily') {
        dayField.classList.add('d-none');
        timeField.classList.remove('d-none');
        dateField.classList.add('d-none');
    } else {
        dayField.classList.add('d-none');
        timeField.classList.add('d-none');
        dateField.classList.remove('d-none');
    }
}

function applyDarkMode(enabled) {
    const body = document.body;
    const icon = document.getElementById("darkModeIcon");

    if (enabled) {
        body.classList.add("dark-mode");
        icon.classList.replace("bi-sun-fill", "bi-moon-stars-fill");
    } else {
        body.classList.remove("dark-mode");
        icon.classList.replace("bi-moon-stars-fill", "bi-sun-fill");
    }
}

// PHP-rendered values
const latestValue = <?= $latest['original_value'] ?>;
const latestType = "<?= $latest['type'] ?>";
const latestUnit = "<?= $latest['original_unit'] ?>";
let inRange = false;
let low = 0, high = 0;

if (latestUnit === 'mg/dL') {
    if (latestType === 'fasting') {
        low = 70;
        high = 100;
    } else {
        low = 140;
        high = 180;
    }
    inRange = (latestValue >= low && latestValue <= high);
}

document.getElementById("latestReadingStatus").innerHTML = `
    <p class="card-value text-secondary mb-1">${latestValue} <span class="fs-6">${latestUnit}</span></p><br>
    <span class="badge ${inRange ? 'bg-success' : 'bg-danger'}">${inRange ? '<i class="bi bi-check-circle"></i> Within range' : 'Out of Range ⚠️'}</span>
`;

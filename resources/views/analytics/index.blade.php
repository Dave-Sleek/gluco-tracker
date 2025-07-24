@extends('layouts.an')

@section('title', 'Dashboard - Blood Sugar Analytics')


<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h3>Welcome, <span id="userName">{{ Auth::user()->full_name }}</span></h3> -->

        <!-- <button id="darkModeToggle" class="btn btn-sm bg-transparent" data-bs-toggle="tooltip" title="Toggle Dark Mode">
            <i id="darkModeIcon" class="bi bi-moon-stars-fill fs-5"></i>
        </button> -->
    </div>

    <select id="filterSelect" class="form-select w-auto d-inline-block">
        <option value="week">Last 7 Days</option>
        <option value="month">Last 30 Days</option>
    </select>

    <button class="btn btn-success ms-2" id="exportCSV">Export to CSV</button>

    <div class="mt-4">
        <h5>Estimated A1C: <span id="a1cValue">--</span></h5>
    </div>

    <canvas id="fastingChart" width="400" height="200"></canvas>
    <canvas id="afterMealChart" width="400" height="200"></canvas>

    <div id="calendar"></div>
</div>

<script>
    const fetchUrl = "{{ route('analytics.fetch') }}";
</script>
<!-- <script src="{{ asset('js/analytics.js') }}" defer></script> -->
<script src="{{url('frontend/assets/js/analytics.js')}}"  defer></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.min.js"></script>
<!-- FullCalendar JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>

<script>
// document.addEventListener("DOMContentLoaded", () => {
//   const filterSelect = document.getElementById("filterSelect");
//   const exportBtn = document.getElementById("exportCSV");
//   const a1cDisplay = document.getElementById("a1cValue");

//   let fastingChart, afterMealChart;

//   async function fetchAnalytics(filter = "week") {
//     try {
//         const response = await fetch("{{ route('analytics.fetch') }}?filter=" + filter);
        
//         if (!response.ok) throw new Error(`HTTP Error! Status: ${response.status}`);
        
//         const data = await response.json();
//         console.log("Fetched Data:", data);
//     } catch (error) {
//         console.error("Fetch Error:", error);
//     }
// }

//   function updateCharts(fastingData, afterMealData) {
//     const fastingCtx = document.getElementById("fastingChart").getContext("2d");
//     const afterMealCtx = document.getElementById("afterMealChart").getContext("2d");

//     const fastingDates = fastingData.map(d => d.date);
//     const fastingValues = fastingData.map(d => d.value);
//     const afterMealDates = afterMealData.map(d => d.date);
//     const afterMealValues = afterMealData.map(d => d.value);

//     if (fastingChart) fastingChart.destroy();
//     if (afterMealChart) afterMealChart.destroy();

//     fastingChart = new Chart(fastingCtx, {
//       type: "line",
//       data: {
//         labels: fastingDates,
//         datasets: [{
//           label: "Fasting",
//           data: fastingValues,
//           borderColor: "#4e73df",
//           fill: false
//         }]
//       }
//     });

//     afterMealChart = new Chart(afterMealCtx, {
//       type: "line",
//       data: {
//         labels: afterMealDates,
//         datasets: [{
//           label: "After Meal",
//           data: afterMealValues,
//           borderColor: "#e74a3b",
//           fill: false
//         }]
//       }
//     });
//   }

//   function updateCalendar(events) {
//     const calendarEl = document.getElementById("calendar");
//     calendarEl.innerHTML = ""; // Clear previous

//     const calendar = new FullCalendar.Calendar(calendarEl, {
//       initialView: "dayGridMonth",
//       height: 500,
//       events
//     });

//     calendar.render();
//   }

//   function updateA1CEstimate(value) {
//     a1cDisplay.textContent = value + " %";
//   }

//   function exportToCSV(data) {
//     const csvRows = [["Date", "Value"]];
//     data.forEach(entry => csvRows.push([entry.date, entry.value]));

//     const csvContent = csvRows.map(row => row.join(",")).join("\n");
//     const blob = new Blob([csvContent], { type: "text/csv" });
//     const link = document.createElement("a");
//     link.href = URL.createObjectURL(blob);
//     link.download = "blood_sugar_data.csv";
//     document.body.appendChild(link);
//     link.click();
//     document.body.removeChild(link);
//   }

//   // Handle filter changes
//   filterSelect.addEventListener("change", () => {
//     fetchAnalytics(filterSelect.value);
//   });

//   fetchAnalytics();
// });
// </script>

<script>
// Dark Mode Handling (Retains localStorage preference)
// document.addEventListener("DOMContentLoaded", function () {
//   const toggleBtn = document.getElementById("darkModeToggle");
//   const icon = document.getElementById("darkModeIcon");
//   const body = document.body;

//   function applyDarkMode(enabled) {
//     if (enabled) {
//       body.classList.add("dark-mode");
//       icon.classList.replace("bi-sun-fill", "bi-moon-stars-fill");
//     } else {
//       body.classList.remove("dark-mode");
//       icon.classList.replace("bi-moon-stars-fill", "bi-sun-fill");
//     }
//   }

//   const isDark = localStorage.getItem("darkMode") === "enabled";
//   applyDarkMode(isDark);

//   toggleBtn.addEventListener("click", () => {
//     const currentlyDark = body.classList.contains("dark-mode");
//     localStorage.setItem("darkMode", currentlyDark ? "disabled" : "enabled");
//     applyDarkMode(!currentlyDark);
//   });
// });
</script>
<script>
  // Apply dark mode on first visit if system prefers dark
  if (localStorage.getItem("darkMode") === null && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    localStorage.setItem("darkMode", "enabled");
    document.body.classList.add("dark-mode");
  }

  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("darkModeToggle");
    const icon = document.getElementById("darkModeIcon");
    const body = document.body;

    // Apply mode based on saved preference
    function applyDarkMode(enabled) {
      body.classList.toggle("dark-mode", enabled);
      icon.className = enabled ? "bi bi-moon-stars-fill" : "bi bi-sun-fill";
    }

    const isDark = localStorage.getItem("darkMode") === "enabled";
    applyDarkMode(isDark);

    // Toggle mode and save preference
    toggleBtn?.addEventListener("click", () => {
      const nowDark = !body.classList.contains("dark-mode");
      localStorage.setItem("darkMode", nowDark ? "enabled" : "disabled");
      applyDarkMode(nowDark);
    });
  });
</script>
</body>
</html>
document.addEventListener("DOMContentLoaded", () => {
  const filterSelect = document.getElementById("filterSelect");
  const exportBtn = document.getElementById("exportCSV");
  const a1cDisplay = document.getElementById("a1cValue");

  let fastingChart, afterMealChart;

  const fetchUrl = window.fetchUrl || "/fetch-analytics"; // fallback if not set from Blade

  // Fetch & display analytics
  async function fetchAnalytics(filter = "week") {
    try {
      const response = await fetch(`${fetchUrl}?filter=${filter}`);
      if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);

      const result = await response.json();
      const data = result.data;

      if (!data || !Array.isArray(data.fasting)) throw new Error("Invalid data structure");

      updateCharts(data.fasting, data.after_meal);
      updateCalendar(data.calendar);
      updateA1CEstimate(data.a1c_estimate);

      exportBtn.onclick = () => exportToCSV([...data.fasting, ...data.after_meal]);
    } catch (error) {
      console.error("Fetch Error:", error);
    }
  }

  function updateCharts(fastingData, afterMealData) {
    const fastingCtx = document.getElementById("fastingChart").getContext("2d");
    const afterMealCtx = document.getElementById("afterMealChart").getContext("2d");

    if (fastingChart) fastingChart.destroy();
    if (afterMealChart) afterMealChart.destroy();

    fastingChart = new Chart(fastingCtx, {
      type: "line",
      data: {
        labels: fastingData.map(d => d.date),
        datasets: [{ label: "Fasting", data: fastingData.map(d => d.value), borderColor: "#4e73df", fill: false }]
      }
    });

    afterMealChart = new Chart(afterMealCtx, {
      type: "line",
      data: {
        labels: afterMealData.map(d => d.date),
        datasets: [{ label: "After Meal", data: afterMealData.map(d => d.value), borderColor: "#e74a3b", fill: false }]
      }
    });
  }

  function updateCalendar(events) {
    const calendarEl = document.getElementById("calendar");
    calendarEl.innerHTML = "";

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: "dayGridMonth",
      height: 500,
      events
    });

    calendar.render();
  }

  function updateA1CEstimate(value) {
    a1cDisplay.textContent = value + " %";
  }

  function exportToCSV(data) {
    const csvRows = [["Date", "Value"]];
    data.forEach(entry => csvRows.push([entry.date, entry.value]));

    const csvContent = csvRows.map(row => row.join(",")).join("\n");
    const blob = new Blob([csvContent], { type: "text/csv" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "blood_sugar_data.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  // Event Listener
  filterSelect.addEventListener("change", () => fetchAnalytics(filterSelect.value));

  // Init
  fetchAnalytics();
});

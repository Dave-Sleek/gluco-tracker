// CSV Download
    document.getElementById('downloadCsvBtn').addEventListener('click', function () {
      const rows = Array.from(document.querySelectorAll('#historyTable tr'));
      let csv = rows.map(row => Array.from(row.children).map(cell => `"${cell.textContent.trim()}"`).join(",")).join("\n");
      const blob = new Blob([csv], { type: 'text/csv' });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'conversion_history.csv';
      a.click();
      window.URL.revokeObjectURL(url);
    });

    // Clear History
    document.getElementById('clearHistoryBtn').addEventListener('click', function () {
      if (!confirm('Are you sure you want to delete all your history?')) return;
      fetch('clear_history.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'clear=1'
      })
      .then(response => response.text())
      .then(msg => location.reload())
      .catch(err => alert('Error clearing history.'));
    });

    // Search Filter
    document.getElementById('searchInput').addEventListener('input', function () {
      const filter = this.value.toLowerCase();
      document.querySelectorAll('#historyTable tbody tr').forEach(row => {
        row.style.display = Array.from(row.children).some(td => td.textContent.toLowerCase().includes(filter)) ? '' : 'none';
      });
    });
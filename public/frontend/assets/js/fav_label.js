function bindFavoriteAndLabelHandlers() {
  // Favorite button click handler
  document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', () => {
      const conversionId = button.dataset.id;
      const isFavorite = button.textContent === '★' ? 1 : 0;
      const newFavorite = isFavorite ? 0 : 1;

      fetch('../backend_control/update_favorite.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${conversionId}&favorite=${newFavorite}`
      })
      .then(res => res.text())
      .then(data => {
        if(data === 'success') {
          button.textContent = newFavorite ? '★' : '☆';
          button.classList.toggle('btn-outline-warning');
          button.classList.toggle('btn-outline-secondary');
        } else {
          alert('Failed to update favorite');
        }
      });
    });
  });

  // Label input change handler
  document.querySelectorAll('.label-input').forEach(input => {
    input.addEventListener('change', () => {
      const conversionId = input.dataset.id;
      const label = input.value.trim();

      fetch('../backend_control/update_label.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${conversionId}&label=${encodeURIComponent(label)}`
      })
      .then(res => res.text())
      .then(data => {
        if(data !== 'success') {
          alert('Failed to update label');
        }
      });
    });
  });
}

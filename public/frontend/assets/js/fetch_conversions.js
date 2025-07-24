document.addEventListener("DOMContentLoaded", () => {
  const filterSelect = document.getElementById("filterSelect");
  const pagination = document.getElementById("pagination");
  const searchInput = document.getElementById("searchInput");
  const tableBodyContainer = document.querySelector("#historyTable tbody");

  let currentFilter = filterSelect ? filterSelect.value : "all";
  let currentPage = 1;
  let currentSearch = "";

  function debounce(func, delay) {
    let timer;
    return function(...args) {
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(this, args), delay);
    };
  }

  function loadConversions(page = 1) {
    currentPage = page;
    if (filterSelect) currentFilter = filterSelect.value;
    if (searchInput) currentSearch = searchInput.value.trim();

    let url = `../backend_control/fetch_conversions.php?page=${page}&filter=${encodeURIComponent(currentFilter)}`;
    if(currentSearch) {
      url += `&search=${encodeURIComponent(currentSearch)}`;
    }

    fetch(url)
      .then(response => response.json())
      .then(res => {
        if (res.error) {
          alert(res.error);
          return;
        }

        if (!tableBodyContainer) return;

        const { data, total_pages, current_page } = res;

        if (!data || data.length === 0) {
          tableBodyContainer.innerHTML = `<tr><td colspan="8" class="text-center">No conversions found.</td></tr>`;
        } else {
          tableBodyContainer.innerHTML = data.map((row, index) => `
            <tr>
              <td>${(page - 1) * 10 + index + 1}</td>
              <td>${row.original_value}</td>
              <td>${row.original_unit}</td>
              <td>${row.converted_value}</td>
              <td>${row.converted_unit}</td>
              <td>${row.converted_at}</td>
              <td>
                <button class="btn btn-sm btn-outline-${row.favorite ? 'warning' : 'secondary'} favorite-btn" data-id="${row.id}">
                  ${row.favorite ? '★' : '☆'}
                </button>
              </td>
              <td>
                <input type="text" class="form-control label-input" data-id="${row.id}" value="${row.label || ''}" placeholder="Add label">
              </td>
            </tr>
          `).join("");
        }

        // Build pagination only if pagination container exists
        if (pagination) {
          let pageLinks = '';
          for (let i = 1; i <= total_pages; i++) {
            pageLinks += `
              <li class="page-item ${i === current_page ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
              </li>`;
          }
          pagination.innerHTML = pageLinks;

          pagination.querySelectorAll(".page-link").forEach(link => {
            link.addEventListener("click", e => {
              e.preventDefault();
              const newPage = parseInt(e.target.dataset.page);
              if (newPage !== currentPage) {
                loadConversions(newPage);
              }
            });
          });
        }

        // If you have a function to bind favorite & label input events, call it here safely
        if (typeof bindFavoriteAndLabelHandlers === "function") {
          bindFavoriteAndLabelHandlers();
        }
      })
      .catch(err => {
        console.error("Error loading conversions:", err);
        if (tableBodyContainer) {
          tableBodyContainer.innerHTML = `<tr><td colspan="8" class="text-center text-danger">Failed to load data.</td></tr>`;
        }
      });
  }

  // Events
  if (filterSelect) {
    filterSelect.addEventListener("change", () => {
      loadConversions(1);
    });
  }

  if (searchInput) {
    searchInput.addEventListener("input", debounce(() => {
      loadConversions(1);
    }, 500));
  }

  // Initial load
  loadConversions(1);
});

let allBooks = [];

function renderBooks(books) {
  const tbody = document.querySelector(".table-responsive table tbody");
  if (!tbody) return;

  tbody.innerHTML = "";

  if (books.length === 0) {
    tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No books found.</td></tr>';
    return;
  }

  books.forEach(function (book) {
    const tr = document.createElement("tr");

    const isOutOfStock = book.stock === 0;
    const stockDisplay = isOutOfStock
      ? '0 <span style="color: #6c757d; font-style: italic;">(Out of Stock)</span>'
      : book.stock;
    const deleteBtnAttr = isOutOfStock
      ? 'disabled style="opacity: 0.5; cursor: not-allowed;"'
      : "";

    tr.innerHTML = `
      <td>${book.title}</td>
      <td>${book.author}</td>
      <td>${book.year}</td>
      <td>${stockDisplay}</td>
      <td>
        <button type="button" class="btn btn-delete" ${deleteBtnAttr}>Delete</button>
      </td>
    `;

    tbody.appendChild(tr);
  });

  if (typeof initDeleteConfirm === "function") {
    initDeleteConfirm();
  }
}

function initBookSearch() {
  const searchInput = document.getElementById("search-input");
  if (!searchInput) return;

  searchInput.addEventListener("input", function () {
    const keyword = searchInput.value.toLowerCase().trim();
    const filteredBooks = allBooks.filter(function (book) {
      return (
        book.title.toLowerCase().includes(keyword) ||
        book.author.toLowerCase().includes(keyword)
      );
    });
    renderBooks(filteredBooks);
  });
}

function loadBooks() {
  const loadingIndicator = document.getElementById("loading-indicator");

  if (loadingIndicator) {
    loadingIndicator.style.display = "block";
  }

  const urlParams = new URLSearchParams(window.location.search);
  const dataUrl = urlParams.get("error") === "1"
    ? "../data/books-invalid.json"
    : "../data/books.json";

  fetch(dataUrl)
    .then(function (response) {
      if (!response.ok) {
        throw new Error("HTTP error! status: " + response.status);
      }
      return response.json();
    })
    .then(function (data) {
      if (loadingIndicator) {
        loadingIndicator.style.display = "none";
      }
      allBooks = data;
      renderBooks(allBooks);
      initBookSearch();
    })
    .catch(function (error) {
      if (loadingIndicator) {
        loadingIndicator.style.display = "none";
      }
      console.error("Failed to load books:", error);
      const tbody = document.querySelector(".table-responsive table tbody");
      if (tbody) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #d9534f; padding: 1.5rem;">Failed to load book data. Please check connection or JSON file.</td></tr>';
      }
    });
}

document.addEventListener("DOMContentLoaded", function () {
  loadBooks();
});
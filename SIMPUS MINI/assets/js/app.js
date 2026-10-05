function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector("header nav");

  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
  });
}

function initDeleteConfirm() {
  document.querySelectorAll(".btn-delete").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const row = btn.closest("tr");
      const name = row ? row.querySelector("td")?.textContent : "this item";
      const confirmed = confirm('Are you sure you want to delete "' + name + '"?');

      if (confirmed && row) {
        row.remove();
      }
    });
  });
}

function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table");

  if (!input || !table) return;

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(function (row) {
      const firstCell = row.querySelector("td");
      const text = firstCell ? firstCell.textContent.toLowerCase() : "";
      row.style.display = text.includes(keyword) ? "" : "none";
    });
  });
}

function showError(input, message) {
  clearError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = message;
  input.insertAdjacentElement("afterend", span);
}

function clearError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

function initFormValidation() {
  const form = document.getElementById("form-add");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    let valid = true;

    const title = form.querySelector("[name='title'], [name='name']");
    if (title && title.value.trim() === "") {
      showError(title, "This field is required.");
      valid = false;
    } else if (title) {
      clearError(title);
    }

    const author = form.querySelector("[name='author']");
    if (author && author.value.trim() === "") {
      showError(author, "This field is required.");
      valid = false;
    } else if (author) {
      clearError(author);
    }

    const year = form.querySelector("[name='year']");
    if (year) {
      const value = parseInt(year.value, 10);
      if (isNaN(value) || value < 1900 || value > 2026) {
        showError(year, "Year must be between 1900 and 2026.");
        valid = false;
      } else {
        clearError(year);
      }
    }

    const stock = form.querySelector("[name='stock']");
    if (stock) {
      const value = parseInt(stock.value, 10);
      if (isNaN(value) || value < 0) {
        showError(stock, "Stock cannot be negative.");
        valid = false;
      } else {
        clearError(stock);
      }
    }

    const isbn = form.querySelector("[name='isbn']");
    if (isbn && isbn.value.trim() !== "") {
      const isbnPattern = /^[0-9-]+$/;
      if (!isbnPattern.test(isbn.value.trim())) {
        showError(isbn, "ISBN only accepts digits and hyphens.");
        valid = false;
      } else {
        clearError(isbn);
      }
    }

    if (!valid) {
      e.preventDefault();
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initDeleteConfirm();
  initTableFilter();
  initFormValidation();
});
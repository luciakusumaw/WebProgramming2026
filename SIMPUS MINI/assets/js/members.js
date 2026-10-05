function renderMembers(members) {
  const tbody = document.querySelector(".table-responsive table tbody");
  if (!tbody) return;

  tbody.innerHTML = "";

  members.forEach(function (member) {
    const tr = document.createElement("tr");

    tr.innerHTML = `
      <td>${member.member_no}</td>
      <td>${member.name}</td>
      <td>${member.address}</td>
      <td>${member.phone_no}</td>
      <td>
        <button type="button" class="btn btn-delete">Delete</button>
      </td>
    `;

    tbody.appendChild(tr);
  });

  if (typeof initDeleteConfirm === "function") {
    initDeleteConfirm();
  }
}


function loadMembers() {
  const loadingIndicator = document.getElementById("loading-indicator");

  if (loadingIndicator) {
    loadingIndicator.style.display = "block";
  }

  fetch("../data/members.json")
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
      renderMembers(data);
    })
    .catch(function (error) {
      if (loadingIndicator) {
        loadingIndicator.style.display = "none";
      }
      console.error("Failed to load members:", error);
      const tbody = document.querySelector(".table-responsive table tbody");
      if (tbody) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #d9534f;">Failed to load member data. Please check connection or JSON file.</td></tr>';
      }
    });
}


document.addEventListener("DOMContentLoaded", function () {
  loadMembers();
});
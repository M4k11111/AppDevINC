const base_url = "http://localhost/backend";
let selectedId = null;

document.addEventListener("DOMContentLoaded", () => {
  fetchEmployees();

  document.getElementById("addForm").addEventListener("submit", addEmployee);
  document.getElementById("editForm").addEventListener("submit", updateEmployee);
});

function fetchEmployees() {
  fetch(`${base_url}/getemployees/`)
    .then(res => res.json())
    .then(data => renderTable(Array.isArray(data) ? data : data.data || []))
    .catch(err => console.error(err));
}

function renderTable(data) {
  const tbody = document.getElementById("employeeTable");
  tbody.innerHTML = "";

  data.forEach(emp => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${emp.employeeid}</td>
      <td>${emp.firstname} ${emp.lastname}</td>
      <td>
        <button onclick="startEdit(${emp.id}, '${emp.employeeid}', '${emp.firstname}', '${emp.lastname}')">Edit</button>
        <button onclick="deleteEmployee(${emp.id})">Delete</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

function addEmployee(e) {
  e.preventDefault();
  const employeeid = document.getElementById("employeeId").value;
  const firstname = document.getElementById("firstName").value;
  const lastname = document.getElementById("lastName").value;

  fetch(`${base_url}/addemployee/`, {
    method: "POST",
    body: JSON.stringify({ employeeid, firstname, lastname }),
  }).then(() => {
    e.target.reset();
    fetchEmployees();
  });
}

function startEdit(id, employeeid, firstname, lastname) {
  selectedId = id;
  document.getElementById("editEmployeeId").value = employeeid;
  document.getElementById("editFirstName").value = firstname;
  document.getElementById("editLastName").value = lastname;
  document.getElementById("editForm").style.display = "block";
  document.getElementById("addForm").style.display = "none";
}

function updateEmployee(e) {
  e.preventDefault();
  const employeeid = document.getElementById("editEmployeeId").value;
  const firstname = document.getElementById("editFirstName").value;
  const lastname = document.getElementById("editLastName").value;

  fetch(`${base_url}/editemployee/`, {
    method: "POST",
    body: JSON.stringify({ id: selectedId, employeeid, firstname, lastname }),
  }).then(() => {
    cancelEdit();
    fetchEmployees();
  });
}

function deleteEmployee(id) {
  fetch(`${base_url}/deleteemployee/`, {
    method: "POST",
    body: JSON.stringify({ id }),
  }).then(() => fetchEmployees());
}

function cancelEdit() {
  selectedId = null;
  document.getElementById("editForm").style.display = "none";
  document.getElementById("addForm").style.display = "block";
}




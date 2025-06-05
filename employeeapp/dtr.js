const base_url = "http://localhost/backend";

document.addEventListener("DOMContentLoaded", () => {
  fetchDTR();

  document.getElementById("timeForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const employeeid = document.getElementById("employeeId").value.trim();
    if (!employeeid) return;

    await fetch(`${base_url}/addtimein/`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ employeeid }),
    });

    document.getElementById("employeeId").value = "";
    fetchDTR();
  });
});

async function fetchDTR() {
  try {
    const res = await fetch(`${base_url}/getdtr/`);
    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
    const data = await res.json();
    renderTable(data);
  } catch (err) {
    console.error("Fetch error:", err);
  }
}

function renderTable(data) {
  const tbody = document.getElementById("dtrTable");
  tbody.innerHTML = "";

  data.forEach(row => {
    const timeIn = formatTime(row.timein);
    const timeOut = formatTime(row.timeout);

    console.log('Timeout value:', row.timeout);

    tbody.insertAdjacentHTML('beforeend', `
      <tr>
        <td>${row.employeeid}</td>
        <td>${timeIn}</td>
        <td>${timeOut}</td>
        <td class="actions">
          ${(!row.timeout || row.timeout === '0000-00-00 00:00:00') ? `<button onclick="timeout('${row.employeeid}')">Time Out</button>` : ''}
        </td>
      </tr>
    `);
  });
}


async function timeout(employeeid) {
  try {
    const res = await fetch(`${base_url}/addtimeout/`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ employeeid }),
    });

    const json = await res.json();
    if (json.success) {
      alert("Time Out recorded");
    } else {
      alert(json.message || "Failed to record Time Out");
    }
    fetchDTR();
  } catch (err) {
    console.error(err);
    alert("Error recording Time Out");
  }
}

function formatTime(datetimeStr) {
  if (!datetimeStr) return '';
  const fixedStr = datetimeStr.replace(' ', 'T');
  const date = new Date(fixedStr);
  if (isNaN(date)) return '';
  return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

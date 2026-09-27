<!DOCTYPE html>
<html>
<head>
    <title>Permits</title>
</head>
<body>

<h2>All Permits</h2>

<button onclick="loadPermits()">Load Permits</button>

<table border="1" id="table">
    <tr>
        <th>Code</th>
        <th>Visitor</th>
        <th>Park</th>
        <th>Date</th>
        <th>Status</th>
    </tr>
</table>

<script>
async function loadPermits() {
    let token = localStorage.getItem("token");

    let res = await fetch("/api/v1/permits", {
        headers: {
            "Authorization": "Bearer " + token
        }
    });

    let data = await res.json();

    let table = document.getElementById("table");

    data.forEach(p => {
        let row = `<tr>
            <td>${p.permit_code}</td>
            <td>${p.visitor_name}</td>
            <td>${p.park_id}</td>
            <td>${p.visit_date}</td>
            <td>${p.status}</td>
        </tr>`;

        table.innerHTML += row;
    });
}
</script>

</body>
</html>
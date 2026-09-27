<!DOCTYPE html>
<html>
<head>
    <title>Create Permit</title>
</head>
<body>

<h2>Create Permit</h2>

<form id="permitForm">
    <input type="text" id="visitor_name" placeholder="Visitor Name"><br><br>

    <input type="number" id="park_id" placeholder="Park ID"><br><br>

    <input type="date" id="visit_date"><br><br>

    <input type="number" id="amount" placeholder="Amount"><br><br>

    <button type="submit">Save Permit</button>
</form>

<script>
document.getElementById("permitForm").addEventListener("submit", async function(e){
    e.preventDefault();

    let token = localStorage.getItem("token");

    let res = await fetch("/api/v1/permits", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token
        },
        body: JSON.stringify({
            visitor_name: document.getElementById("visitor_name").value,
            park_id: document.getElementById("park_id").value,
            visit_date: document.getElementById("visit_date").value,
            amount: document.getElementById("amount").value
        })
    });

    let data = await res.json();

    alert("Permit created: " + data.permit_code);
});
</script>

</body>
</html>
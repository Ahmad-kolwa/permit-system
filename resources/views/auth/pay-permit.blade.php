<!DOCTYPE html>
<html>
<head>
    <title>Pay Permit</title>
</head>
<body>

<h2>Pay Permit</h2>

<form id="payForm">
    <input type="text" id="permit_code" placeholder="Permit Code"><br><br>
    <input type="number" id="amount" placeholder="Amount"><br><br>
    <input type="text" id="payment_reference" placeholder="Payment Reference"><br><br>

    <button type="submit">Pay</button>
</form>

<script>
document.getElementById("payForm").addEventListener("submit", async function(e){
    e.preventDefault();

    let token = localStorage.getItem("token");

    let code = document.getElementById("permit_code").value;

    let res = await fetch(`/api/v1/permits/${code}/pay`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token
        },
        body: JSON.stringify({
            amount: document.getElementById("amount").value,
            payment_reference: document.getElementById("payment_reference").value
        })
    });

    let data = await res.json();

    alert(data.message);
});
</script>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<form id="registerForm">
    <input type="text" id="name" placeholder="Full Name"><br><br>
    <input type="email" id="email" placeholder="Email"><br><br>
    <input type="password" id="password" placeholder="Password"><br><br>

    <select id="role">
        <option value="officer">Officer</option>
        <option value="accountant">Accountant</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

<script>
document.getElementById("registerForm").addEventListener("submit", async function(e){
    e.preventDefault();

    let res = await fetch("/api/v1/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            password: document.getElementById("password").value,
            role: document.getElementById("role").value
        })
    });

    let data = await res.json();

    alert("User created successfully");
    window.location.href = "/login";
});
</script>

</body>
</html>
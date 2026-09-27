<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form id="loginForm">
    <input type="email" id="email" placeholder="Email"><br><br>
    <input type="password" id="password" placeholder="Password"><br><br>
    <button type="submit">Login</button>
</form>

<script>
document.getElementById("loginForm").addEventListener("submit", async function(e){
    e.preventDefault();

    let res = await fetch("/api/v1/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email: document.getElementById("email").value,
            password: document.getElementById("password").value
        })
    });

    let data = await res.json();

    localStorage.setItem("token", data.token);

    alert("Login successful");
    window.location.href = "/permits";
});
</script>

</body>
</html>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("authForm");
  const toggle = document.getElementById("toggleAuth");
  const authBtn = document.getElementById("authBtn");
  const authType = document.getElementById("authType");
  const authMsg = document.getElementById("authMessage");

  const loginUrl = form.dataset.login;
  const registerUrl = form.dataset.register;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  toggle.addEventListener("click", (e) => {
    e.preventDefault();
    if (authType.value === "login") {
      authType.value = "register";
      authBtn.textContent = "Register";
      toggle.textContent = "Already have an account? Login";
    } else {
      authType.value = "login";
      authBtn.textContent = "Login";
      toggle.textContent = "Don't have an account? Register";
    }
  });

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    authBtn.disabled = true;
    authMsg.textContent = "";

    const data = {
      email: document.getElementById("email").value,
      password: document.getElementById("password").value
    };

    const url = authType.value === "login" ? loginUrl : registerUrl;

    fetch(url, {
      method: "POST",
      headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          "Accept": "application/json"
      },
      body: JSON.stringify(data),
      credentials: "same-origin"
  })  
    .then(res => res.json())
    .then(res => {
      authMsg.textContent = res.message || "Success!";
      if (res.success) {
        setTimeout(() => {
          window.location.href = "/dashboard"; // Laravel route
        }, 1000);
      } else {
        authBtn.disabled = false;
      }
    })
    .catch(error => {
      authMsg.textContent = "An error occurred. Please try again.";
      //console.error("Auth error:", error);
      authBtn.disabled = false;
    });
  });
});

// Theme Toggle

const toggleBtn = document.querySelector('.theme-toggle');
const icon = toggleBtn.querySelector('i');
const body = document.body;

// Load saved mode
if (localStorage.getItem("theme") === "dark") {
    body.classList.add("dark-mode");
    icon.classList.replace("bx-moon", "bx-sun");
}

toggleBtn.addEventListener("click", () => {
    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
        icon.classList.replace("bx-moon", "bx-sun");
    } else {
        localStorage.setItem("theme", "light");
        icon.classList.replace("bx-sun", "bx-moon");
    }
});

document.querySelectorAll(".toggle-password").forEach(icon => {
    icon.addEventListener("click", () => {
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirmPassword");

        const isPassword = password.type === "password";

        // Toggle type for both fields
        password.type = isPassword ? "text" : "password";
        confirmPassword.type = isPassword ? "text" : "password";

        // Toggle icon classes
        icon.classList.toggle("bx-hide", !isPassword);
        icon.classList.toggle("bx-show", isPassword);
    });

});
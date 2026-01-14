function validateRegisterForm() {
  document.querySelectorAll(".error").forEach((el) => (el.innerText = ""));

  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  if (name.length < 3) {
    document.getElementById("nameError").innerText =
      "Name must be at least characters.";
  }
  const emailRegex = /^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  if (!emailRegex.test(email)) {
    document.getElementById("emailError").innerText = "Enter a valid email";
  }
  if (password.length < 6) {
    document.getElementById("passwordError").innerText =
      "Password must be at least 6 characters.";
  }
}

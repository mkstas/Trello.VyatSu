const form = document.querySelector(".form");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const formData = new FormData(form);
  const dataObject = Object.fromEntries(formData.entries());

  alert(JSON.stringify(dataObject));
});

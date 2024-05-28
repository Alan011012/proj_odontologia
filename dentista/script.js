document.addEventListener("DOMContentLoaded", function () {
  const toggler = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");

  toggler.addEventListener("click", function () {
      sidebar.classList.toggle("collapsed");
  });
});
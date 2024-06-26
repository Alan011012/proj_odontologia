document.addEventListener("DOMContentLoaded", function () {
  const toggler = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");

  toggler.addEventListener("click", function () {
      sidebar.classList.toggle("collapsed");
  });
});
(function () {
  'use strict'

  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
      .forEach(function (form) {
          form.addEventListener('submit', function (event) {
              if (!form.checkValidity()) {
                  event.preventDefault()
                  event.stopPropagation()
              }

              form.classList.add('was-validated')
          }, false)
      })
})()



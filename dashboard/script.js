document.addEventListener("DOMContentLoaded", function () {
  const statusSelects = document.querySelectorAll(".status-select");

  statusSelects.forEach(select => {
    updateSelectColor(select); // initial color

    select.addEventListener("change", function () {
      updateSelectColor(select);
    });
  });

  function updateSelectColor(select) {
    select.classList.remove("status-completed", "status-pending", "status-process");

    switch (select.value) {
      case "Completed":
        select.classList.add("status-completed");
        break;
      case "Pending":
        select.classList.add("status-pending");
        break;
      case "Process":
        select.classList.add("status-process");
        break;
    }
  }
});

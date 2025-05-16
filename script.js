
  document.addEventListener("DOMContentLoaded", function () {
    var subscribeModal = document.getElementById("subscribeModal");
    var openModalBtn = document.getElementById("openSubscribeModal");
    var closeBtn = document.querySelector("#subscribeModal .close");

    // Check if the button exists before binding the click
    if (openModalBtn) {
      openModalBtn.addEventListener("click", function (e) {
        e.preventDefault();
        subscribeModal.style.display = "block";
      });
    }

    // Close the modal when the close button is clicked
    if (closeBtn) {
      closeBtn.addEventListener("click", function () {
        subscribeModal.style.display = "none";
      });
    }

    // Close the modal when clicking outside the modal content
    window.addEventListener("click", function (event) {
      if (event.target === subscribeModal) {
        subscribeModal.style.display = "none";
      }
    });

    // Handle the subscription form submit
    var subscribeForm = document.getElementById("subscribeForm");
    if (subscribeForm) {
      subscribeForm.addEventListener("submit", function (event) {
        event.preventDefault();
        var email = document.getElementById("email").value;
        var plan = document.getElementById("plan").value;

        if (!email || !plan) {
          alert("Please fill out both fields.");
          return;
        }

        alert("Subscribed with " + email + " to the " + plan + " plan!");
        subscribeModal.style.display = "none";
      });
    }
  });


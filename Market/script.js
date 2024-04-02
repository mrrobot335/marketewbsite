const buttons = document.querySelectorAll('.market-buttons .btn');
const widgets = document.querySelectorAll('.market-widget');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        const target = button.getAttribute('data-target');
        widgets.forEach(widget => {
            if (widget.id === target) {
                widget.classList.add('active');
            } else {
                widget.classList.remove('active');
            }
        });
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var dropdowns = document.getElementsByClassName("dropdown");

    for (var i = 0; i < dropdowns.length; i++) {
        var dropdown = dropdowns[i];
        dropdown.addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownContent = this.querySelector(".dropdown-content");
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches(".dropbtn")) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
        }
    };
});
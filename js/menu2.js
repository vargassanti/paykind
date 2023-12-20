// Manejar elementos de tipo flecha
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("showMenu");
    });
}

// Manejar la barra lateral
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-chevron-right");

sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

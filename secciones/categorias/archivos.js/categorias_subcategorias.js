const showButtons = document.querySelectorAll(".show-button");
    showButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const subcategory = button.parentElement.nextElementSibling;
            const allSubcategories = document.querySelectorAll(".subcategory");

            if (subcategory.style.display === "none" || subcategory.style.display === "") {
                // Mostrar las subcategorías
                allSubcategories.forEach((sub) => {
                    sub.style.display = "none"; // Ocultar todas las demás subcategorías
                });
                subcategory.style.display = "block";
            } else {
                subcategory.style.display = "none"; // Ocultar la subcategoría actual
            }
        });
    });
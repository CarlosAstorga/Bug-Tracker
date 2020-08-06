var token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

document.getElementById("menu-toggle").addEventListener("click", () => {
    document.getElementById("wrapper").classList.toggle("toggled");
    let state = document
        .getElementById("wrapper")
        .classList.contains("toggled");

    fetch(`/sidebar/${state}`, {
        headers: {
            "X-CSRF-TOKEN": token
        }
    });
});

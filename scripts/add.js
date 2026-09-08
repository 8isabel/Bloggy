const buttons = document.querySelectorAll("#landscape, #portrait, #panorama, #boomerang");
const sections = document.querySelectorAll(".landscape, .portrait, .panorama, .boomerang");

buttons.forEach((button, i) => {
    button.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        sections.forEach(s => s.classList.add("hidden"));

        button.classList.add("active");
        sections[i].classList.remove("hidden");
    });
});

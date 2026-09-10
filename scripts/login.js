document.addEventListener("DOMContentLoaded", () => {
    const loginLink = document.getElementById("login");
    const modal = document.getElementById("loginModal");
    const closeBtn = document.getElementById("loginClose");
    const form = document.getElementById("loginForm");

    if (!loginLink || !modal) return;

    loginLink.addEventListener("click", (e) => {
        e.preventDefault();
        modal.classList.add("open");
    });

    closeBtn?.addEventListener("click", () => {
        modal.classList.remove("open");
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.remove("open");
        }
    });

});

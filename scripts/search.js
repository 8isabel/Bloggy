document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const sort = document.getElementById("sort");
    const posts = document.querySelectorAll(".blog-post[data-category]");

    if (!searchInput || !sort || posts.length === 0) return;

    function filterPosts() {
        const q = searchInput.value.toLowerCase().trim();
        const category = sort.value;

        posts.forEach((post) => {
            const matchCategory = category === "all" || post.dataset.category === category;
            const matchSearch =
                q === "" ||
                (post.dataset.title || "").includes(q) ||
                (post.dataset.author || "").includes(q);

            post.style.display = matchCategory && matchSearch ? "" : "none";
        });
    }

    searchInput.addEventListener("input", filterPosts);
    sort.addEventListener("change", filterPosts);
});

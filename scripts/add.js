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

const postBtn = document.getElementById("post");

if (postBtn) {
    postBtn.addEventListener("click", () => {
        const layoutBtn = document.querySelector(".edit .active");
        const layout = layoutBtn ? layoutBtn.id : "landscape";
        const category = document.getElementById("sort").value;
        const author = document.getElementById("author").value;

        let title = "";
        let content = "";
        let imageInput = null;

        if (layout === "landscape") {
            title = document.getElementById("landscape-title").value;
            content = document.getElementById("landscape-text").value;
            imageInput = document.querySelector(".landscape input[type='file']");
        } else if (layout === "portrait") {
            title = document.getElementById("portrait-title").value;
            const intro = document.getElementById("portrait-intro").value;
            const text = document.getElementById("portrait-text").value;
            content = intro + "|||" + text;
            imageInput = document.querySelector(".portrait input[type='file']");
        } else if (layout === "panorama") {
            title = document.getElementById("panorama-title").value;
            const text = document.getElementById("panorama-text").value;
            const extra = document.getElementById("panorama-extra").value;
            content = text + "|||" + extra;
            imageInput = document.querySelector(".panorama input[type='file']");
        } else if (layout === "boomerang") {
            title = document.getElementById("boomerang-title").value;
            const text1 = document.getElementById("boomerang-text-1").value;
            const text2 = document.getElementById("boomerang-text-2").value;
            content = text1 + "|||" + text2;
            imageInput = document.querySelector(".boomerang input[type='file']");
        }

        const form = document.createElement("form");
        form.method = "POST";
        form.action = "post.php";
        form.enctype = "multipart/form-data";

        const fields = { title, author, category, content, layout };
        for (const key in fields) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = fields[key];
            form.appendChild(input);
        }

        if (imageInput && imageInput.files.length > 0) {
            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.name = "image";
            const data = new DataTransfer();
            data.items.add(imageInput.files[0]);
            fileInput.files = data.files;
            form.appendChild(fileInput);
        }

        document.body.appendChild(form);
        form.submit();
    });
}

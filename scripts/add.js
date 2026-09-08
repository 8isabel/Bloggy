let landscape = document.getElementById("landscape");
let portrait = document.getElementById("portrait");
let panorama = document.getElementById("panorama");
let boomerang = document.getElementById("boomerang");

let land = document.querySelector(".landscape");
let port = document.querySelector(".portrait");
let pan = document.querySelector(".panorama");
let boom = document.querySelector(".boomerang");

landscape.addEventListener("click", function() {
    landscape.classList.add("active");
    portrait.classList.remove("active");
    panorama.classList.remove("active");
    boomerang.classList.remove("active");

    land.classList.remove("hidden");
    port.classList.add("hidden");
    pan.classList.add("hidden");
    boom.classList.add("hidden");
});

portrait.addEventListener("click", function() {
    portrait.classList.add("active");
    landscape.classList.remove("active");
    panorama.classList.remove("active");
    boomerang.classList.remove("active");

    land.classList.add("hidden");
    port.classList.remove("hidden");
    pan.classList.add("hidden");
    boom.classList.add("hidden");
});

panorama.addEventListener("click", function() {
    panorama.classList.add("active");
    landscape.classList.remove("active");
    portrait.classList.remove("active");
    boomerang.classList.remove("active");

    land.classList.add("hidden");
    port.classList.add("hidden");
    pan.classList.remove("hidden");
    boom.classList.add("hidden");
});

boomerang.addEventListener("click", function() {
    boomerang.classList.add("active");
    landscape.classList.remove("active");
    portrait.classList.remove("active");
    panorama.classList.remove("active");

    land.classList.add("hidden");
    port.classList.add("hidden");
    pan.classList.add("hidden");
    boom.classList.remove("hidden");
});
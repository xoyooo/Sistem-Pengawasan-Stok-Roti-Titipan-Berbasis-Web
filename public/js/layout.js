const burger = document.getElementById("burger");
const sidebar = document.getElementById("mobile-sidebar");
const closeSidebar = document.getElementById("closeSidebar");

burger?.addEventListener("click", () => {
    sidebar.classList.remove("closing");
    sidebar.classList.add("open");
    document.body.style.overflow = "hidden";
});

const closeSide = () => {
    sidebar.classList.remove("open");
    sidebar.classList.add("closing");
    document.body.style.overflow = "";
    setTimeout(() => sidebar.classList.remove("closing"), 350);
};

closeSidebar?.addEventListener("click", closeSide);
sidebar?.addEventListener("click", (e) => {
    if (e.target === sidebar) closeSide();
});

window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
        sidebar.classList.remove("open", "closing");
        document.body.style.overflow = "";
    }
});

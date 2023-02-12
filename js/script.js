let btnUser = document.getElementById("user-btn");
let profile = document.querySelector(".profile");


btnUser.addEventListener("click", (eo) => {
    profile.classList.toggle("active");
})

window.onscroll = () => {
    profile.classList.remove("active");
}
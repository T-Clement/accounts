const notif = document.querySelector(".js-notif");
if (notif) {
    notif.addEventListener("animationend", function () {
        notif.classList.remove("active");
    });
}
function clearNotif() {
    const notif = document.querySelector(".js-notif");
    if (notif) {
        notif.addEventListener("animationend", function () {
            notif.classList.remove("active");
        });
    }
}




// function displayNotif(notif, notifTxt) {
//     return `<p class='notif-style ${notif} active  js-notif'>${notifTxt}</p>`;
// }
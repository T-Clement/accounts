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


// update form
const updateForm = document.querySelector(".js-update-form");
console.log(updateForm);
console.log("Le form est au dessus");
const textOperation = document.querySelectorAll('.js-operation-txt');
console.log(textOperation[1].innerText);
const updateButtons = document.querySelectorAll(".js-update");
updateButtons.forEach(button => {
    button.addEventListener("click", function(event) {
        updateForm.classList.add("form-update-active");
        currentOperationId = event.currentTarget.dataset.id;

        // get all the values to put in in update form
        const operation = event.currentTarget.closest(".js-transaction-row");
        const textOperation = operation.querySelector(".js-operation-txt").innerText;
        const amountOperation = operation.querySelector(".js-operation-amount").innerText;
        const dateOperation = operation.querySelector(".js-operation-date").dateTime;
        const categoryOperation = operation.dataset.category;
        console.log(textOperation, amountOperation, dateOperation, categoryOperation);

        console.log(updateForm);
        updateForm.querySelector(".js-operation-id").value = currentOperationId;
        updateForm.querySelector("#name").value = textOperation;

        updateForm.querySelector("#date").value = dateOperation;
        updateForm.querySelector("#amount").value = amountOperation;
        // updateForm.querySelector("#category").value = categoryOperation;



    })
})

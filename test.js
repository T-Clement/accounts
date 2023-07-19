const accountAmount = document.querySelector(".js-account-amount");
const currentAmount = parseFloat(accountAmount.textContent);
console.log(currentAmount);
// console.log(parseFloat(accountAmount.textContent));
// exit;
accountAmount.textContent = accountAmount.textContent;


// bug si on supprime plusieurs tâches, le montant ne se met à jour qu'une seule fois
const deleteButtons = document.querySelectorAll(".js-delete");
deleteButtons.forEach(button => {
    button.addEventListener("click", function(e) {
        idTransaction = e.currentTarget.dataset.id;
        console.log(idTransaction);
        deleteTransaction(idTransaction)
        .then((apiResponse) => {
            if(!apiResponse.result) {
                console.error("Problème rencontré lors de la suppression de la transaction");
                return;
            }
            // console.log(apiResponse.idTransaction);
            const transactionAmountDOM = document.querySelectorAll(".js-transaction-amount" + `[data-id="${apiResponse.idTransaction}"]`);
            console.log(transactionAmountDOM);
            const transactionAmount = transactionAmountDOM.textContent;
            console.log(transactionAmount);
    
            // update in DOM the new account amount
            if(transactionAmount[0] == '-') {
                console.log("test du négatif");
                currentAmount = currentAmount + parseFloat(transactionAmount); 
            } else {
                currentAmount = currentAmount - parseFloat(transactionAmount);
            }
            accountAmount.textContent = currentAmount + parseFloat(transactionAmount);
        });
        const transactionRow = e.currentTarget.closest(".js-transaction-row");
        console.log(transactionRow);
        transactionRow.remove();




        // updateAccountAmount().then((apiResponse => {
        //     console.log(apiResponse);
        //     accountAmount.textContent = apiResponse.amount["account_amount"];
        // }))
        
    })
});

function deleteTransaction(idTransaction) {
    const data = {
        action: "delete",
        idTransaction: idTransaction,
        // token: getToken()
    }
    return callAPI("DELETE", data);
}

async function callAPI(method, data) {
    try {
        const response = await fetch("api.php", {
            method: method,
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });
        return response.json();
    } catch (error) {
        console.error("Unable to load datas from the server : " + error);
    }
}


function updateAccountAmount() {
    // const accountAmount = document.querySelector(".js-account-amount");
    const data = {
        action: "getTotalAmount"
    }
    return callAPI("PUT", data);
}

// const deleteButtons = document.querySelectorAll(".js-delete");
// deleteButtons.forEach((btn) => {
//     btn.addEventListener("click", (e) => {
//         console.log(e.currentTarget.dataset.id);
        
//         deleteTask(e.currentTarget.dataset.id, e.currentTarget.dataset.priority)
//             .then((apiResponse) => {
//                 console.log(apiResponse);
//                 if(!apiResponse.result) {
//                     console.error("Problème rencontré dans la suppression");
//                     return;
//                 }
//                 const task = document.querySelector(`li[data-id="${apiResponse.idTask}"]`);
//                 task.remove();
//                 document.querySelector("#notif").innerHTML = displayNotif(apiResponse.notif, apiResponse.notifTxt);
//                 clearNotif();
//             });
//     })
// })
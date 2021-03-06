//création de la requete
const request = new XMLHttpRequest;
let old_request = 0;

//document elements
const msg_input = document.getElementById("message-input");
const send_btn = document.getElementById("send-message");
const msg_canva = document.getElementById("message-canva");


//variables
const id_sender = document.getElementById("id-sender").innerText;
const id_receveur = document.getElementById("id-receveur").innerText;
const token = document.getElementById("token").innerText;
let last_msg;


//listener
send_btn.addEventListener("click", sendMsg);



function sendMsg(){
    let msg = msg_input.value;
    msg_input.value = "";

    //si le message n'est pas vide
    if(msg.length > 0){
        console.log('envoi du message');
        request.addEventListener("load", displayMsg);
        request.open("GET", `https://cookit.ovh/ressources/api/api_msg.php?task=write&msg=${msg}&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
        request.send();
    }
}


function displayMsg() {

    if (old_request != request.response) {
        //update de l'ancienne requete
        old_request = request.response;

        //clear de la canva
        msg_canva.innerText = "";

        //affichage des messages
        for (const message of JSON.parse(request.response)) {

            //création des elements
            const div = document.createElement("div");
            const msg = document.createElement("p");

            //style en fonction de l'envoyeur de message
            if(message['ID_SENDER'] == id_sender){
                div.setAttribute("class", "d-flex flex-row justify-content-end pt-1");
                msg.setAttribute("class", "small p-2 me-3 mb-1 text-white rounded-3 bg-primary");

            }else{
                div.setAttribute("class", "d-flex flex-row justify-content-start");
                msg.setAttribute("class", "small p-2 ms-3 mb-1 rounded-3");
                msg.setAttribute("style", "background-color: #f5f6f7;");
            }

            msg.innerText = message['MESSAGE'];

            div.appendChild(msg);
            msg_canva.appendChild(div);

            last_msg = msg;
        }

        last_msg.scrollIntoView();
    }
}

//fonction de refresh des messages pour la messagerie instannée
function refresh() {
    request.addEventListener("load", function(){
        displayMsg();
    });
    request.open("GET", `https://cookit.ovh/ressources/api/api_msg.php?task=read&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
    request.send();
    console.log("refreshed");
    setTimeout(refresh, 2000);
}

refresh();
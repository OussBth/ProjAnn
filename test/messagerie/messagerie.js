//création de la requete
const request = new XMLHttpRequest;


//document elements
const msg_input = document.getElementById("message-input");
const send_btn = document.getElementById("send-message");


//variables
const id_sender = document.getElementById("id-sender").innerText;
const id_receveur = document.getElementById("id-receveur").innerText;
const token = document.getElementById("token").innerText;


//listener
send_btn.addEventListener("click", sendMsg);



function sendMsg(){
    let msg = msg_input.value;
    console.log("test btn");
    console.log(msg);
    console.log(id_sender);
    console.log(id_receveur);
    console.log(token);

    if(msg.length > 0){
        console.log('envoi du message');
        request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=write&msg=${msg}&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
        request.send();
    }
}


function displayMsg() {
    request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=read&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
    request.send();

    const div = document.createElement("div");

    for (const message in request.response) {
        



    }


}

function refresh() {
    displayMsg();
    console.log("refreshed");
    setTimeout(refresh, 2000);
}

refresh();
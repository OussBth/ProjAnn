//requetes
const request_ajax = new XMLHttpRequest;
const request_admin = new XMLHttpRequest;

//elements du dom
const search_bar_user = document.getElementById("search-bar-user");
const users = document.getElementById("users");

const users_php = document.getElementById("users-php");
//const next_prev = document.getElementById("next-prev");




//écouteur
search_bar_user.addEventListener("input", onclickuser);

//variable
let adminDisplay = 0;
let keywords = '';



function onclickuser() {
    //récupération de la valeur dans la barre de recherche
    keywords = search_bar_user.value;

    //envoi de la requete
    request_ajax.addEventListener("load", display_results_user);

    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api_user.php?keyword=${keywords}`);
    request_ajax.send();
}

function display_results_user() {
    users.innerText = "";
    if(keywords == ""){
        users_php.hidden = false;
    }else{
        users_php.hidden = true;
    
        let users_resp = JSON.parse(request_ajax.response);

        for (const user of users_resp) {

            const main_div = document.createElement("div");
            main_div.setAttribute("class", "col-lg-3 col-md-4 col-sm-6");

            const second_div = document.createElement("div");
            second_div.setAttribute("class", "card bg-color text-center shadow p-3 mb-5 rounded");


            const img = document.createElement("img");
            img.setAttribute("src", `${user['PATH_AVATAR']}`);
            img.setAttribute("class", "card-img-top cardh my-3");

            const pseudo = document.createElement("div");
            pseudo.innerText = `${user['PSEUDO']}`;

            const a = document.createElement("a");
            a.setAttribute("href", `https://cookit.ovh/profil.php?id=${user['ID']}`);
            a.setAttribute("class", "bg-light rounded my-3");
            a.innerText = "Voir le profil";


            second_div.appendChild(img);
            second_div.appendChild(pseudo);
            second_div.appendChild(a);

            main_div.appendChild(second_div);

            users.appendChild(main_div);

            



            // if (adminDisplay === 1){

            //     const aAdmin = document.createElement("a");
            //     aAdmin.setAttribute("href", `https://cookit.ovh/delRecette.php?id=${recipe['ID_RECIPE']}`);

            //     const btnAdmin = document.createElement("button");
            //     //---------------------------------------------------------------
            //     btnAdmin.setAttribute("class", "btn btn-danger px-3");
            //     btnAdmin.innerHTML = '<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>';

            //     admin_div.appendChild(aAdmin);
            //     admin_div.appendChild(btnAdmin);
            // }
        }
    }
}

function changeAdminDP(){
    adminRespons = JSON.parse(request_admin.response);
    console.log(request_admin.response);
    if (adminRespons == 1) {
        adminDisplay = 1;
    }
}

// if(adminDisplay == 0){
//     request_admin.addEventListener("load", changeAdminDP);
//     request_admin.open("GET", `https://cookit.ovh/ressources/api/api.php?action=3&id=${id}&token=${token}`);
//     request_admin.send();

//}

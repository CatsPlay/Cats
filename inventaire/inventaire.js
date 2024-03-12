"use strict";

const name = "...";
const APIurl = "...";

fetch(APIurl)
    .then(response => response.json())
    .then(data =>{

        console.log(`liste ${name}:`);
        data.foeEach{repo => {
            console.log(`- ${repo.name}`);
        });
})
.catch(error => {
    console.error(`Erreur lors de l'appel API : ${error.message}`);
});

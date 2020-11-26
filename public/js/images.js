window.onload = () => {

    //Gestion des suppressions d'images

    let links = document.querySelectorAll("[data-delete]");

    for (link of links) 
    {
        link.addEventListener("click", function(e) {

            // on empêche la navigation
            e.preventDefault();

            //on demande confirmation

            if (confirm('Voulez-vous supprimer cette image ?'))
            {
                //On envoie une requête ajax vers le href du lien avec méthode DELETE

                fetch(this.getAttribute("href"), {
                    method : "DELETE", 
                    headers: {
                        'X-Requested-With': "XMLHttpRequest",
                        'ContentType': "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    //Récupération de la réponse en JSON
                    response => response.json()
                ).then(data => {
                    if (data.success)
                    {
                        this.parentElement.remove();
                    } else {
                        alert(data.error);
                    }
                }).catch(e => alert(e))
            }
        })
    }
}
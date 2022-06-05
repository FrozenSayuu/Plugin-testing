
/**
 * Hanterar exempel 2 formuläret och skicka formuläret med fetch
 */

let saveComment = document.querySelector('#commentform');
saveComment.addEventListener('submit', doAjax);   // Lyssna på submit på formuläret, kör doAjax2 när det submittas.

function doAjax(event)
{
    event.preventDefault();

    /*
     * Skapa formulär data som skickas med fetch request:et.
     * Det gör vi igenom JS klassen Formdata, som tar emot ett formulär som input.
     * De kommer den lägga ni alla våra inputs med name, som sedan kan skickas som form post data
     *
     * I exemplet ovan la vi till action med appendd(), men nu finns den som en hidden input.
     * */

    let formData = new FormData(saveComment);

    /* Här använder vi formulärets action attribut istället för ajax variabeln myAjax för URL dit ajax-anroopet ska skickas */
    fetch(saveComment.getAttribute('action'),
    {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data =>
        {
            if(data.type === "success")
            {
                const success = document.querySelector('.comments');
                success.innerHTML = `<h3>Your comment is saved!</h3>`;

                console.log(data.message);
            }
            else 
            {
                alert("Your comment could not be added");
            }
        })
        .catch((error) =>
        {
            console.error('Error:', error);
        });
}
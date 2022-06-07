let saveComment = document.querySelector('#commentform');
saveComment.addEventListener('submit', doAjax);   // Listenes at submit on the form, runs doAjax function when activated.a

function doAjax(event)
{
    event.preventDefault();

    /*
     * Create form data that sends with fetch request.
     * This we do with the JS class Formdata, that takes it as an input.
     * It will put in all of our inputs with name, that can later send as form post data.
     * */

    let formData = new FormData(saveComment);

    /* Here we uses the form's action attribut, instead of the ajax variabel myAjax, for the URL where ajax-request will be sent */
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
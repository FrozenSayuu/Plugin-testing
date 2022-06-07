let sendForm = document.querySelector('#contactform');
sendForm.addEventListener('submit', doAjax);   // Listenes at submit on the form, runs doAjax function when activated.a

function doAjax(event)
{
    event.preventDefault();

    /*
     * Create form data that sends with fetch request.
     * This we do with the JS class Formdata, that takes it as an input.
     * It will put in all of our inputs with name, that can later send as form post data.
     * */

    let formData = new FormData(sendForm);

    /* Here we uses the form's action attribut, instead of the ajax variabel myAjax, for the URL where ajax-request will be sent */
    fetch(sendForm.getAttribute('action'),
    {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data =>
        {
            if(data.type === "success")
            {
                const success = document.querySelector('.success');
                success.innerHTML = `<h3>Your form is sent!</h3>`;

                console.log(data.message);
            }
            else 
            {
                alert("Your form could not be sent");
            }
        })
        .catch((error) =>
        {
            console.error('Error:', error);
        });
}
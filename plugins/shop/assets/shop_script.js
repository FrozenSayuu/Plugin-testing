const submitForm = document.querySelector('.review_form');

submitForm.addEventListener('submit', doAjaxEvent);

function doAjaxEvent(event)
{
    event.preventDefault();
    
    const formData = new FormData(submitForm);

    fetch(submitForm.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(body =>
        {
            const success = document.querySelector('#success');
            success.innerHTML = `Your review is sent!`;

            console.log(body);
        })
        .catch()
}
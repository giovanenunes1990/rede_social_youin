if (document.querySelector('.chat-buttons')) {

    let id = document.querySelector('.chat-buttons').getAttribute('other-id');

    document.querySelector('#send-message').addEventListener('click', async () => {
        let userOnline = document.querySelector('.header-chat').getAttribute('online');

        let txt = document.querySelector('.chat-buttons .feed-new-input').innerHTML;
        document.querySelector('.chat-buttons .feed-new-input').innerHTML = '';
        if (txt != '') {
            let data = new FormData();
            data.append('txt', txt);

            let req = await fetch(BASE + '/message/' + id, {
                method: 'POST',
                body: data
            });
            let json = await req.json();

            if (json.error == '') {

                let html = '<div class="my">';
                html += '<div class="triangle"></div>';
                html += '<div class="message">';
                html += '<p>' + txt + '</p>';
                html += '<div class="footer-msg">';
                html += '<div class="flex-alt">';
                html += ' <img class="first-check" max-width="20" height="12" src="' + BASE + '/assets/images/check-gray.png" />';
                (userOnline == 'true') ? html += '<img class="second-check" src="' + BASE + '/assets/images/check-gray.png" />' : '';
                html += '</div>';
                html += '<p class="time">' + json.time + '</p>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                document.querySelector('.chat').innerHTML += html;

            }
            window.scrollTo(0, document.querySelector("body").scrollHeight);
            document.querySelector('.chat').scrollTo(0, document.querySelector(".chat").scrollHeight);
        }

    });

    function sawMyMessage() {
        document.querySelectorAll('.chat .my .first-check').forEach(item => {
            item.setAttribute('src', BASE + '/assets/images/check-blue.png')
        });
        document.querySelectorAll('.chat .my .second-check').forEach(item => {
            item.setAttribute('src', BASE + '/assets/images/check-blue.png')
        });

    }

    async function verifyNewMessage() {
        let idOther = document.querySelector('.header-chat').getAttribute('data-other-id');

        let html = '';
        let req = await fetch(BASE + '/othermessage/' + idOther);
        let json = await req.json();


        if (json[0].length > 0) {
            json[0].forEach(item => {

                if (item.image == null) {

                    html = '<div class="other">';
                    html += '<div class="triangle"></div>';
                    html += '<div class="message">';
                    html += '<p>' + item.message + '</p>';
                    html += '<p class="time">' + item.creation + '</p>';
                    html += '</div>';
                    html += '</div>';
                    document.querySelector('.chat').innerHTML += html;
                    sawMyMessage();
                    window.scrollTo(0, document.querySelector("body").scrollHeight);
                    document.querySelector('.chat').scrollTo(0, document.querySelector(".chat").scrollHeight);
                } else {
                    let html = '<div class="other">';
                    html += '<div class="triangle"></div>';
                    html += '<div class="message">';
                    html += '<img src="' + BASE + '/media/uploads/' + item.image + '" alt="" />';
                    html += '<p class="time">' + item.creation + '</p>';
                    html += '</div>';
                    html += '</div>';
                    document.querySelector('.chat').innerHTML += html;
                    sawMyMessage();
                    window.scrollTo(0, document.querySelector("body").scrollHeight);
                    document.querySelector('.chat').scrollTo(0, document.querySelector(".chat").scrollHeight);
                }

            });
            sawMyMessage();
        }

    }
    setInterval(() => {
        verifyNewMessage();
    }, 1000);

}

let msgFile = document.querySelector('.file-input-chat');
function sendImg() {
    msgFile.click();
}
msgFile.addEventListener('change', async function (obj) {
    let photo = msgFile.files[0];
    let id = document.querySelector('.chat-buttons').getAttribute('other-id');
    let userOnline = document.querySelector('.header-chat').getAttribute('online');
    let formData = new FormData();


    formData.append('photo', photo);

    let req = await fetch(BASE + '/photo/' + id, {
        method: 'POST',
        body: formData
    });
    let json = await req.json();

    if (json.error == '') {
        let html = '<div class="my">';
        html += '<div class="triangle"></div>';
        html += '<div class="message">';
        html += '<img src="' + BASE + '/media/uploads/' + json.img + '" >';
        html += '<div class="footer-msg">';
        html += '<div class="flex-alt">';
        html += ' <img class="first-check" max-width="20" height="12" src="' + BASE + '/assets/images/check-gray.png" />';
        (userOnline == 'true') ? html += '<img class="second-check" src="' + BASE + '/assets/images/check-gray.png" />' : '';
        html += '</div>';
        html += '<p class="time">' + json.time + '</p>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        document.querySelector('.chat').innerHTML += html;

    }

    window.scrollTo(0, document.querySelector("body").scrollHeight);
});


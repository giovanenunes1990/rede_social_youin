if (document.querySelector('#chat-message')) {
    document.querySelectorAll('#chat-message').forEach(item => {
        let message = item.innerHTML;
        if (message.length > 50) {
            message = message.substr(0, 50) + '...';
            item.innerHTML = message;
        }
    });
};

function openDialog(msg, link) {
    document.querySelector('.overlay').style.display = 'block';
    document.querySelector('.alert p').innerHTML = msg;
    document.querySelector('.alert #link').setAttribute('href', link);

    if (document.querySelector('.alert p').innerHTML == 'Tem certeza que deseja excluir permanentemente sua conta?') {
        document.querySelector('.confirm-delete-bill').style.display = 'flex';
        document.querySelector('.alert .btn-confirm').style.display = 'none';
        document.querySelector('.alert .btn-confirm a#link').style.display = 'none';
        document.querySelector('.alert .btn-confirm input[type=submit]').style.display = 'block';
        document.querySelector('.alert form').setAttribute('action', link);

        let value = document.querySelector('.confirm-delete-bill input[name=password]');

        value.addEventListener('keyup', function () {
            document.querySelector('.alert .btn-confirm').style.display = 'flex';
        });

    } else {
        document.querySelector('.confirm-delete-bill').style.display = 'none';
        document.querySelector('.alert .btn-confirm').style.display = 'flex';
    }

}
document.querySelector('.btn-close').addEventListener('click', function () {
    document.querySelector('.overlay').style.display = 'none';

    document.querySelector('.alert .btn-confirm a#link').style.display = 'block';
    document.querySelector('.confirm-delete-bill input[name=password]').value = '';
    document.querySelector('.alert .btn-confirm input[type=submit]').style.display = 'none';
});
document.querySelector('#close-overlay').addEventListener('click', function () {
    document.querySelector('.overlay').style.display = 'none';

    document.querySelector('.alert .btn-confirm a#link').style.display = 'block';
    document.querySelector('.confirm-delete-bill input[name=password]').value = '';
    document.querySelector('.alert .btn-confirm input[type=submit]').style.display = 'none';
});

if (document.querySelector('.welcome-modal')) {
    document.querySelector('.close-welcome').addEventListener('click', () => {
        document.querySelector('.welcome-modal').style.display = 'none';

        fetch(BASE + '/aticivy');

    });
}

if (document.querySelector(".warning")) {

    document.querySelector('.warning .box-warning .close').addEventListener('click', () => {
        document.querySelector('.warning').style.display = 'none';
    });

    setTimeout(() => {
        document.querySelector(".warning").style.display = 'none';
    }, 3000);
}

if (document.querySelector('#cover')) {
    let txt = document.querySelector('#cover').getAttribute('src');
    txt = txt.split('/');
    let index = parseInt(txt.length - 1);
    txt = txt[index];

    if (txt == 'cover.jpg') {
        document.querySelector('#removecover').setAttribute('onclick', '');
        document.querySelector('#removecover span').style.color = 'gray';
        document.querySelector('#removecover img').setAttribute('src', BASE + '/assets/images/trash-gray.png');
    }
}

if (document.querySelector('#avatar')) {
    let txt = document.querySelector('#avatar').getAttribute('src');
    txt = txt.split('/');
    let index = parseInt(txt.length - 1);
    txt = txt[index];

    if (txt == 'default.jpg') {
        document.querySelector('#removephoto').setAttribute('onclick', '');
        document.querySelector('#removephoto span').style.color = 'gray';
        document.querySelector('#removephoto img').setAttribute('src', BASE + '/assets/images/trash-gray.png');
    }
}

let feedFile = document.querySelector('.feed-new-file');
function uploadCall() {
    feedFile.click();
}
feedFile.addEventListener('change', async function (obj) {
    let photo = feedFile.files[0];
    let formData = new FormData();

    formData.append('photo', photo);

    let req = await fetch(BASE + '/ajax/upload', {
        method: 'POST',
        body: formData
    });
    let json = await req.json();

    if (json.error != '') {
        alert(json.error);
    }

    window.location.href = window.location.href;
});

function setActiveTab(tab) {
    document.querySelectorAll('.tab-item').forEach(function (e) {
        if (e.getAttribute('data-for') == tab) {
            e.classList.add('active');
        } else {
            e.classList.remove('active');
        }
    });
}
function showTab() {
    if (document.querySelector('.tab-item.active')) {
        let activeTab = document.querySelector('.tab-item.active').getAttribute('data-for');
        document.querySelectorAll('.tab-body').forEach(function (e) {
            if (e.getAttribute('data-item') == activeTab) {
                e.style.display = 'block';
            } else {
                e.style.display = 'none';
            }
        });
    }
}

if (document.querySelector('.tab-item')) {
    showTab();
    document.querySelectorAll('.tab-item').forEach(function (e) {
        e.addEventListener('click', function (r) {
            setActiveTab(r.target.getAttribute('data-for'));
            showTab();
        });
    });
}


function closeFeedwindow() {
    document.querySelectorAll('.feed-item-more-window').forEach(item => {
        item.style.display = 'none';
    });
    document.removeEventListener('click', closeFeedwindow);
}


document.querySelectorAll('.feed-item-head-btn').forEach(item => {
    item.addEventListener('click', () => {
        closeFeedwindow();
        item.querySelector('.feed-item-more-window').style.display = 'block';

        setTimeout(() => {
            document.addEventListener('click', closeFeedwindow);
        }, 500);

    });
});


if (document.querySelector('.like-btn')) {
    document.querySelectorAll('.like-btn').forEach(item => {
        item.addEventListener('click', () => {
            let id = item.closest('.feed-item').getAttribute('data-id');
            let count = parseInt(item.innerText);
            if (item.classList.contains('on') === false) {
                item.classList.add('on');
                item.innerText = ++count;
            } else {
                item.classList.remove('on');
                item.innerText = --count;
            }

            fetch(BASE + '/ajax/like/' + id);

        });
    });

}

if (document.querySelector('.fic-item-field')) {
    document.querySelectorAll('.fic-item-field').forEach(item => {
        item.addEventListener('keyup', async (e) => {
            if (e.keyCode == 13) {

                let id = item.closest('.feed-item').getAttribute('data-id');
                let txt = item.value;
                item.value = '';
                if (txt != '') {
                    let data = new FormData();
                    data.append('id', id);
                    data.append('txt', txt);


                    let req = await fetch(BASE + '/ajax/comment', {
                        method: 'POST',
                        body: data
                    });
                    let json = await req.json();

                    if (json.error == '') {
                        let html = '<div class="fic-item row m-height-10 m-width-20">';
                        html += '<div class="fic-item-photo">';
                        html += '<a href="' + BASE + json.link + '"><img src="' + BASE + json.avatar + '" /></a>';
                        html += '</div>';
                        html += '<div class="fic-item-info">';
                        html += '<a href="' + BASE + json.link + '">' + json.name + '</a>';
                        html += json.body;
                        html += '</div>';
                        html += '</div>';

                        item.closest('.feed-item')
                            .querySelector('.feed-item-comments-area')
                            .innerHTML += html;
                    }
                }

            }
        });
    });

}

function uploadAvatar() {
    document.querySelector('input[name=avatar]').click();
    let photo = document.querySelector('#avatar');
    let file = document.querySelector('input[name=avatar]');

    file.addEventListener('change', () => {
        if (file.files.length <= 0) {
            return;
        }
        let reader = new FileReader();
        reader.onload = () => {
            photo.src = reader.result;
        }
        reader.readAsDataURL(file.files[0]);
    });
}
function uploadCover() {
    document.querySelector('input[name=cover]').click();
    let photo = document.querySelector('#cover');
    let file = document.querySelector('input[name=cover]');

    file.addEventListener('change', () => {
        if (file.files.length <= 0) {
            return;
        }
        let reader = new FileReader();
        reader.onload = () => {
            photo.src = reader.result;
        }
        reader.readAsDataURL(file.files[0]);
    });
}

if (document.querySelector('.feed-new')) {
    document.querySelector('.feed-new-input-placeholder').addEventListener('click', function (obj) {
        obj.target.style.display = 'none';
        document.querySelector('.feed-new-input').style.display = 'block';
        document.querySelector('.feed-new-input').focus();
        document.querySelector('.feed-new-input').innerText = '';
    });

    document.querySelector('.feed-new-input').addEventListener('blur', function (obj) {
        let value = obj.target.innerText.trim();
        if (value == '') {
            obj.target.style.display = 'none';
            document.querySelector('.feed-new-input-placeholder').style.display = 'block';
        }
    });
}

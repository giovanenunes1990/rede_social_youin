if (document.querySelector('#photos-profile')) {
    let data = [];
    let photos = document.querySelectorAll('#photos-profile .photo');

    photos.forEach(item => {
        let ids = item.getAttribute('id');
        data.push(ids);
    });
    var dataFinal = data.map(function (item) {
        return document.querySelector('#' + item + ' img').getAttribute('src');
    });
}

function nextPhotoModal(currentPhoto) {
    let currentPostion = dataFinal.findIndex(function (item) {
        return (currentPhoto == item);
    });
    if ((currentPostion + 1) == dataFinal.length) {
        return 0;
    } else {
        return currentPostion + 1;
    }
}

function prevPhotoModal(currentPhoto) {
    let currentPostion = dataFinal.findIndex(function (item) {
        return (currentPhoto == item);
    });

    if (currentPostion == 0) {
        return dataFinal.length - 1;
    } else {
        return currentPostion - 1;
    }

}

function callModalPhoto($path) {
    document.querySelector('.modal-photo').style.display = "flex";
    document.querySelector('.modal-inner img').setAttribute('src', $path);
}

if (document.querySelector('.modal-photo')) {
    document.querySelector('.modal-close').addEventListener('click', () => {
        document.querySelector('.modal-photo').style.display = "none";
    });

    document.querySelector('.modal-choice-next').addEventListener('click', () => {
        let next = nextPhotoModal(document.querySelector('.modal-inner img').getAttribute('src'));
        document.querySelector('.modal-inner img').setAttribute('src', dataFinal[next]);
    });

    document.querySelector('.modal-choice-prev').addEventListener('click', () => {
        let prev = prevPhotoModal(document.querySelector('.modal-inner img').getAttribute('src'));
        document.querySelector('.modal-inner img').setAttribute('src', dataFinal[prev]);
    });
}
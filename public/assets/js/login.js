IMask(
    document.getElementById('birthdate'),
    {
        mask: '00/00/0000'
    }
)

if (document.querySelector(".flash")) {
    setTimeout(() => {
        document.querySelector(".flash").style.display = 'none';
    }, 2500);
}

document.querySelector('#password').addEventListener('keyup', () => {
    let confirm = [];
    let value = document.querySelector('#password').value;

    document.querySelector('.verify').style.display = 'block';

    if (/[a-z]/gm.test(value)) {
        document.querySelector('#lower').classList.add('has');
        confirm['lower'] = true;
    } else {
        document.querySelector('#lower').classList.remove('has');
        confirm['lower'] = false;
    }

    if (/[A-Z]/gm.test(value)) {
        document.querySelector('#upper').classList.add('has');
        confirm['upper'] = true;
    } else {
        document.querySelector('#upper').classList.remove('has');
        confirm['upper'] = false;
    }

    if (/[0-9]/gm.test(value)) {
        document.querySelector('#num').classList.add('has');
        confirm['num'] = true;
    } else {
        document.querySelector('#num').classList.remove('has');
        confirm['num'] = false;
    }
    if (/[!?@*$#%&]/gm.test(value)) {
        document.querySelector('#spec').classList.add('has');
        confirm['spec'] = true;
    } else {
        document.querySelector('#spec').classList.remove('has');
        confirm['spec'] = false;
    }

    if (value.length >= 6) {
        document.querySelector('#len').classList.add('has');
        confirm['len'] = true;
    } else {
        document.querySelector('#len').classList.remove('has');
        confirm['len'] = false;
    }


    if (confirm['lower'] == true && confirm['upper'] == true && confirm['num'] == true && confirm['spec'] == true && confirm['len'] == true) {
        document.querySelector('#repeater-password').style.display = 'block';
        document.querySelector('#submit-signup').style.display = 'block';
    }

});

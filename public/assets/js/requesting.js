let id = LOGGEDUSERID;


setInterval(async function () {
    let data = new FormData();
    let req = await fetch(BASE + '/notifications/' + id, {
        method: 'POST',
        body: data
    });
    let json = await req.json();

    if (json.error == '') {
        document.querySelectorAll('.count-noti').forEach((item) => {
            item.innerHTML = json.countnoti;
        });
    }
}, 4000);

setInterval(async function () {


    let data = new FormData();
    let req = await fetch(BASE + '/conversas/' + id, {
        method: 'POST',
        body: data
    });
    let json = await req.json();

    if (json.error == '') {
        document.querySelectorAll('.count-chat').forEach((item) => {
            item.innerHTML = json.countchat;
        });
    }
}, 4000);


const inactivityTime = function () {
    let time;
    // reset timer
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeydown = resetTimer;
    function doSomething() {
        window.location.href = BASE + "/sair";
    }
    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(doSomething, 300000)
    }
};
//inactivityTime();
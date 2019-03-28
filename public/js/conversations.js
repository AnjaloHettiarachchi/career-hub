let query;

// Initialize Firebase
let config = {
    apiKey: "AIzaSyBvFhb3CaBtRBlmlJ5m5mFlGJMpeUJTgCw",
    authDomain: "nsbm-careerhub.firebaseapp.com",
    databaseURL: "https://nsbm-careerhub.firebaseio.com",
    projectId: "nsbm-careerhub",
    storageBucket: "",
    messagingSenderId: "167886166007"
};

let app = firebase.initializeApp(config);
let db = firebase.firestore(app);

function startConversation(ele, mode, sender, receiver) {

    let image = $(ele).children('.image').attr('src');
    let title = $(ele).children('.content').children('.header').html();

    let time = new Date().getTime();

    $('.ui.modal').modal('hide');

    $('#chat-header').html(`<div class="ui list">
                                            <div class="item">
                                                <img class="ui avatar image" src="` + image + `" alt="header-avatar">
                                                <div class="content">
                                                    <div class="ui large header">` + title + `</div>
                                                    <div class="description">Online</div>
                                                </div>
                                            </div>
                                        </div>`);

    $('#chat-room')
        .removeClass('center', 'aligned')
        .html(`<ul id="messages">
                                <div class="ui horizontal divider">` + moment(time).format('DD MMMM YYYY') + `</div>
                           </ul>`);

    if (mode === 's2c') {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            url: '/conversations',
            method: 'POST',
            data: {stu_id: sender, com_id: receiver, doc_id: sender + '_' + receiver},
            success: function () {

                $('#chat-list').html(`<div class="item">
                                        <img class="ui avatar image" src="` + image + `" alt="header-avatar">
                                        <div class="content">
                                            <div class="ui header">` + title + `</div>
                                            <div class="description">Online</div>
                                        </div>
                                      </div>`);

                query = db.collection('conversations')
                    .doc(sender + '_' + receiver)
                    .collection(moment(new Date().getTime()).format('DD-MM-YYYY'))
                    .orderBy('timestamp')
                    .limit(12);

                query.onSnapshot(function (snapshot) {
                    snapshot.docChanges().forEach(function (change) {
                        if (change.type === 'added') {
                            if (change.doc.data().from === 'stu') {
                                displayMessage('me', change.doc.data().text)
                            } else {
                                displayMessage('him', change.doc.data().text)
                            }
                            // console.log(change.doc.data());
                        }
                    })
                }, function (error) {
                    alert(error)
                });

                $('#send-button').on('click', function () {
                    let ele = $('#message');
                    let msg = ele.val();
                    ele.val('');
                    saveMessage(sender + '_' + receiver, 'stu', msg)
                });

                $('#message').on('keyup', function (event) {
                    if (event.keyCode === 13) {
                        let msg = $(this).val();
                        $(this).val('');
                        saveMessage(sender + '_' + receiver, 'stu', msg)
                    }
                });

            }
        });

    } else {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            url: '/conversations',
            method: 'POST',
            data: {stu_id: receiver, com_id: sender, doc_id: sender + '_' + receiver},
            success: function () {

                $('#chat-list').html(`<div class="item">
                                        <img class="ui avatar image" src="` + image + `" alt="header-avatar">
                                        <div class="content">
                                            <div class="ui header">` + title + `</div>
                                            <div class="description">Online</div>
                                        </div>
                                      </div>`);

                query = db.collection('conversations')
                    .doc(sender + '_' + receiver)
                    .collection(moment(new Date().getTime()).format('DD-MM-YYYY'))
                    .orderBy('timestamp')
                    .limit(12);

                query.onSnapshot(function (snapshot) {
                    snapshot.docChanges().forEach(function (change) {
                        if (change.type === 'added') {
                            if (change.doc.data().from === 'com') {
                                displayMessage('me', change.doc.data().text)
                            } else {
                                displayMessage('him', change.doc.data().text)
                            }
                            // console.log(change.doc.data());
                        }
                    })
                }, function (error) {
                    alert(error)
                });

                $('#send-button').on('click', function () {
                    let ele = $('#message');
                    let msg = ele.val();
                    ele.val('');
                    saveMessage(sender + '_' + receiver, 'com', msg)
                });

                $('#message').on('keyup', function (event) {
                    if (event.keyCode === 13) {
                        let msg = $(this).val();
                        $(this).val('');
                        saveMessage(sender + '_' + receiver, 'com', msg)
                    }
                });

            }
        });

    }
}

function resumeConversation(ele, mode, sender, receiver) {

    $(ele).addClass('active');

    let time = new Date().getTime();
    let image = $(ele).children('.image').attr('src');
    let title = $(ele).children('.content').children('.header').html();

    $('#chat-header').html(`<div class="ui list">
                                            <div class="item">
                                                <img class="ui avatar image" src="` + image + `" alt="header-avatar">
                                                <div class="content">
                                                    <div class="ui large header">` + title + `</div>
                                                    <div class="description">Online</div>
                                                </div>
                                            </div>
                                        </div>`);

    $('#chat-room')
        .removeClass('center', 'aligned')
        .html(`<ul id="messages">
                                <div class="ui horizontal divider">` + moment(time).format('DD MMMM YYYY') + `</div>
                           </ul>`);

    if (mode === 's2c') {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            url: '/conversations/get',
            method: 'POST',
            data: {stu_id: sender, com_id: receiver, doc_id: sender + '_' + receiver},
            success: function (res) {

                query = db.collection('conversations')
                    .doc(res)
                    .collection(moment(new Date().getTime()).format('DD-MM-YYYY'))
                    .orderBy('timestamp')
                    .limit(12);

                query.onSnapshot(function (snapshot) {
                    snapshot.docChanges().forEach(function (change) {
                        if (change.type === 'added') {
                            if (change.doc.data().from === 'stu') {
                                console.log(sender);
                                displayMessage('me', change.doc.data().text)
                            } else {
                                displayMessage('him', change.doc.data().text)
                            }
                            // console.log(change.doc.data());
                        }
                    })
                }, function (error) {
                    alert(error)
                });

                $('#send-button').on('click', function () {
                    let ele = $('#message');
                    let msg = ele.val();
                    ele.val('');
                    saveMessage(res, 'stu', msg)
                });

                $('#message').on('keyup', function (event) {
                    if (event.keyCode === 13) {
                        let msg = $(this).val();
                        $(this).val('');
                        saveMessage(res, 'stu', msg)
                    }
                });

            }
        });

    } else {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            url: '/conversations/get',
            method: 'POST',
            data: {stu_id: receiver, com_id: sender, doc_id: sender + '_' + receiver},
            success: function (res) {

                query = db.collection('conversations')
                    .doc(res)
                    .collection(moment(new Date().getTime()).format('DD-MM-YYYY'))
                    .orderBy('timestamp')
                    .limit(12);

                query.onSnapshot(function (snapshot) {
                    snapshot.docChanges().forEach(function (change) {
                        if (change.type === 'added') {
                            if (change.doc.data().from === 'com') {
                                console.log(sender);
                                displayMessage('me', change.doc.data().text)
                            } else {
                                displayMessage('him', change.doc.data().text)
                            }
                            // console.log(change.doc.data());
                        }
                    })
                }, function (error) {
                    alert(error)
                });

                $('#send-button').on('click', function () {
                    let ele = $('#message');
                    let msg = ele.val();
                    ele.val('');
                    saveMessage(res, 'com', msg)
                });

                $('#message').on('keyup', function (event) {
                    if (event.keyCode === 13) {
                        let msg = $(this).val();
                        $(this).val('');
                        saveMessage(res, 'com', msg)
                    }
                });

            }
        });

    }

}

function saveMessage(docId, sender, message) {
    return db.collection('conversations')
        .doc(docId)
        .collection(moment(new Date().getTime()).format('DD-MM-YYYY'))
        .add({
            from: sender,
            text: message,
            timestamp: firebase.firestore.FieldValue.serverTimestamp()
        }).catch(function (error) {
            alert('Firebase Error: ' + error)
        });
}

function displayMessage(type, text) {
    $('#messages').append(`<li class="` + type + `">` + text + `</li>`)
}


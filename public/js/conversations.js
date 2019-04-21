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
let unsubscribe = null;
let doc_id = null;
let sender_type = null;

$(document).ready(function () {
    setDocID();
});

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
        .html(`<ul id="messages"></ul>`);

    if (mode === 's2c') {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            url: '/conversations',
            method: 'POST',
            data: {stu_id: sender, com_id: receiver, doc_id: sender + '_' + receiver},
            success: function () {
                doc_id = sender + '_' + receiver;
                sender_type = 'stu';

                $('#chat-list').html(`<div class="item">
                                        <img class="ui avatar image" src="` + image + `" alt="header-avatar">
                                        <div class="content">
                                            <div class="ui header">` + title + `</div>
                                            <div class="description">Online</div>
                                        </div>
                                      </div>`);

                query = db.collection('conversations')
                    .doc(sender + '_' + receiver)
                    .collection('messages')
                    .orderBy('timestamp')
                    .limit(12);

                if (unsubscribe !== null) {
                    unsubscribe();
                }

                unsubscribe = query.onSnapshot(function (snapshot) {
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
                doc_id = sender + '_' + receiver;
                sender_type = 'com';

                $('#chat-list').html(`<div class="item">
                                        <img class="ui avatar image" src="` + image + `" alt="header-avatar">
                                        <div class="content">
                                            <div class="ui header">` + title + `</div>
                                            <div class="description">Online</div>
                                        </div>
                                      </div>`);

                query = db.collection('conversations')
                    .doc(sender + '_' + receiver)
                    .collection('messages')
                    .orderBy('timestamp')
                    .limit(12);

                if (unsubscribe !== null) {
                    unsubscribe();
                }

                unsubscribe = query.onSnapshot(function (snapshot) {
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

            }
        });

    }
}

function resumeConversation(ele, mode, sender, receiver) {

    $(ele).siblings().removeClass('active');
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
        .html(`<ul id="messages"></ul>`);

    if (mode === 's2c') {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            },
            url: '/conversations/get',
            method: 'POST',
            data: {stu_id: sender, com_id: receiver, doc_id: sender + '_' + receiver},
            success: function (res) {
                doc_id = res;
                sender_type = 'stu';

                query = db.collection('conversations')
                    .doc(res)
                    .collection('messages')
                    .orderBy('timestamp')
                    .limit(12);

                if (unsubscribe !== null) {
                    unsubscribe();
                }

                unsubscribe = query.onSnapshot(function (snapshot) {
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
                doc_id = res;
                sender_type = 'com';

                query = db.collection('conversations')
                    .doc(res)
                    .collection('messages')
                    .orderBy('timestamp')
                    .limit(12);

                if (unsubscribe !== null) {
                    unsubscribe();
                }

                unsubscribe = query.onSnapshot(function (snapshot) {
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

            }
        });

    }

}

function saveMessage(docId, sender, message) {
    db.collection('conversations')
        .doc(docId)
        .collection('messages')
        .add({
            from: sender,
            text: message,
            timestamp: firebase.firestore.FieldValue.serverTimestamp()
        }).catch(function (error) {
            alert('Firebase Error: ' + error)
        });
    console.log(docId);
}

function displayMessage(type, text) {
    $('#messages').append(`<li class="` + type + `">` + text + `</li>`)
}

function setDocID() {
    $('#send-button').on('click', function () {
        let ele = $('#message');
        let msg = ele.val();
        ele.val('');
        saveMessage(doc_id, sender_type, msg)
    });

    $('#message').on('keyup', function (event) {
        if (event.keyCode === 13) {
            let msg = $(this).val();
            $(this).val('');
            saveMessage(doc_id, sender_type, msg)
        }
    });
}


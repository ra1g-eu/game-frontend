<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Window</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS for styling -->
    <style>
        /* Adjust styling as needed */
        body {
            background-color: #f8f9fa;
        }

        .game-window {
            background-color: #ffffff; /* Adjust background color */
            height: 500px; /* Adjust height */
            border: 1px solid #ccc; /* Add borders as needed */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add shadow as needed */
        }

        .resource-info {
            padding: 10px;
            background-color: #007bff; /* Adjust background color */
            color: #fff;
        }

        .button-panel {
            background-color: #f8f9fa;
            padding: 5px;
            border: 1px solid #ccc;
        }

        .chat-box {
            background-color: #ffffff; /* Adjust background color */
            border: 1px solid #ccc;
            height: 200px; /* Adjust height */
        }
    </style>
</head>
<body id="body">
<div class="container mt-4">
    <!-- Resource Info at the top -->
    <div class="row">
        <div class="col-md-12">
            <div class="resource-info">
                Player Resources: XP, Health, Money, Energy, Activity
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="button-panel">
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <button class="btn btn-primary mb-2">Town</button>
                    </div>
                </div>
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <button class="btn btn-primary mb-2">Rankings</button>
                    </div>
                </div>
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <button class="btn btn-primary mb-2">Inventory</button>
                    </div>
                </div>
                <div class="row justify-content-start">
                    <div class="col-auto">
                        <button class="btn btn-primary flex mb-2">Duels</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="game-window">
                xdd
            </div>
        </div>

        <div class="col-md-2">
            <div class="button-panel">
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <button class="btn flex-fill btn-primary mb-2">Character</button>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <button class="btn btn-primary mb-2">Skills</button>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <button class="btn btn-primary mb-2">Quests</button>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <button class="btn btn-primary flex mb-2">Jobs</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-1">
        <div class="col-md-12">
            <div class="chat-box" style="overflow-y: auto;">
                <!-- Chatbox content goes here -->
                <div id="chat-messages" class="mb-2">
                    <!-- Chat messages will be displayed here -->
                </div>
            </div>
            <div class="input-group align-bottom">
                <input type="text" class="form-control" id="chat-input" placeholder="Type your message...">
                <button class="btn btn-primary" id="send-button">Send</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS (Popper.js and Bootstrap.js) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="./js/socket.io.min.js"></script>
<script>
    //remove to disable auth
    document.addEventListener("DOMContentLoaded", function () {
        if (!sessionStorage.getItem("user_token")) {
            let body = document.getElementById("body");
            body.innerHTML = "Invalid session";
        }
    });

    const gameWorld = "Dakota"; // Replace with the actual user token
    let socket = io('ws://localhost:3000?gameWorld=' + gameWorld);
    //const socket = new WebSocket('ws://localhost:3000?user_token=' + userToken);

    // socket.addEventListener('open', (event) => {
    //     console.log('WebSocket connection established.');
    // });
    //
    // socket.addEventListener('error', (error) => {
    //     console.error('WebSocket error:', error);
    // });
    //
    // socket.addEventListener('close', (event) => {
    //     console.log('WebSocket connection closed:', event.code, event.reason);
    // });
    //
    // socket.addEventListener('message', (event) => {
    //     displayMessage(event.data);
    // });

    //
    socket.on('twchatCachedMessages', function (msg) {
        let msgs = JSON.parse(msg);
        for (let i = 0; i < msgs.length; i++) {
            displayMessage(msgs[i]);
        }
    });

    socket.on('chat message', function(msg) {
        displayMessage(JSON.parse(msg));
    });

    socket.on('twChatResend', function(msg) {
        displayMessage(JSON.parse(msg));
    });

    // Function to send a chat message with the user token
    function sendMessage(message) {
        // const messageObject = {
        //     userToken: userToken,
        //     content: message,
        // };

        socket.emit('twchatReceiveMessages', message);
        // Send the message as a JSON string
        //socket.send(JSON.stringify(messageObject));
    }

    // Function to display a chat message
    function displayMessage(message) {
        const chatMessagesElement = document.getElementById('chat-messages');
        const messageElement = document.createElement('div');
        const sender = document.createElement('span');
        const time = document.createElement('span');
        sender.className = "badge bg-primary text-warning";
        sender.innerText = message.player_name + ": ";
        time.innerText = new Date(message.messageTime).toLocaleTimeString();
        time.className = "badge bg-secondary text-primary";
        messageElement.textContent = message.message;
        chatMessagesElement.appendChild(messageElement);
        messageElement.prepend(sender);
        messageElement.prepend(time);

        // Scroll to the bottom of the chatbox to show the latest message
        chatMessagesElement.scrollTop = chatMessagesElement.scrollHeight;
    }

    // Send a chat message when the "Send" button is clicked
    document.getElementById('send-button').addEventListener('click', () => {
        const inputElement = document.getElementById('chat-input');
        const message = inputElement.value.trim();
        if (message) {
            sendMessage(message);
            inputElement.value = '';
        }
    });

    // Send a chat message when the Enter key is pressed in the input field
    document.getElementById('chat-input').addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            const inputElement = document.getElementById('chat-input');
            const message = inputElement.value.trim();
            if (message) {
                sendMessage(JSON.stringify({"message":message, "player_name":"Armchair [TWChat]", "messageTime":Date.now()}));
                displayMessage({"message":message, "player_name":"Armchair [TWChat]", "messageTime":Date.now()});
                inputElement.value = '';
            }
        }
    });
</script>
</body>
</html>

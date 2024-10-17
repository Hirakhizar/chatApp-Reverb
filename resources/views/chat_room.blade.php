@vite('resources/js/app.js')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 15px;
            background-color: #F8F9FA;
        }
        .chat-message {
            margin-bottom: 15px;
        }
        .chat-message .user {
            font-weight: bold;
        }
        .chat-message .message {
            display: inline-block;
            background-color: #E9ECEF;
            padding: 10px;
            border-radius: 10px;
        }
        .chat-message .message.you {
            background-color: #D1E7DD;
        }
        .message-input {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        Chat - Welcome, <span id="username" class="text-success h5">{{$username}}!</span>
                    </div>
                    <div class="card-body">
                        <div class="chat-box" id="chatBox">
                            <div class="chat-message" id='sender'>
                                
                            </div>
                            <div class="chat-message text-end">
                               
                            </div>
                        </div>
                        <div class="message-input d-flex">
                            <input type="text" class="form-control me-2" id="messageInput" placeholder="Type your message here...">
                            <button class="btn btn-primary" onclick="sendMsg()">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
            function sendMsg() {
                let sender = "{{ $username }}";
                let csrfToken = "{{ csrf_token() }}";
                let message = document.getElementById('messageInput').value;
                $.ajax({
                    url: "{{ route('sendMessage') }}",
                    type: "POST",
                    data: {
                        sender: sender,
                        message: message,
                        _token: csrfToken
                    },
            success: function(response) {
            // Append message to chat box
            const chatBox = document.getElementById('chatBox');
            const newMessage = document.createElement('div');
            newMessage.classList.add('chat-message', 'text-end');
            newMessage.innerHTML = `<span class="user">You:</span> <span class="message you">${message}</span>`;
            chatBox.appendChild(newMessage);

            // Scroll to the bottom of the chat box
            chatBox.scrollTop = chatBox.scrollHeight;

            // Clear the input field
            document.getElementById('messageInput').value = "";
        },
        error: function(error) {
            console.error("Error sending message", error);
            alert("Error sending message. Please try again.");
        }
    });    }
            // Make SendMsg available globally
            window.sendMsg = sendMsg;
        });

        window.onload=()=>{
            window.Echo.channel('user-message').listen('MessageSent', function(data){
                if (data.sender !== '{{ $username }}') {
                    const chatBox = document.getElementById('chatBox');
                    const receivedMessage = document.createElement('div');
                    receivedMessage.classList.add('chat-message');
                    receivedMessage.innerHTML = `
                        <span class="user">${data.sender}:</span>
                        <span class="message">${data.message}</span>
                    `;
                    chatBox.appendChild(receivedMessage);

                    // Scroll to the bottom of the chat box
                    chatBox.scrollTop = chatBox.scrollHeight;
                }

                console.log(data)
            })
        }
    </script>
</body>
</html>

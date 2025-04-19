<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Chatbot</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900">

    <!-- Include Header -->
    <?php include 'header.php'; ?>

    <!-- Main Chat Section (Centered) -->
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-4 text-gray-900">🩺 Doctor Chatbot</h2>
            <div id="chatbox" class="h-80 overflow-y-auto bg-gray-100 p-3 rounded-lg space-y-2"></div>
            
            <div class="flex mt-4">
                <input type="text" id="userInput" placeholder="Type your question..." 
                    class="flex-grow p-2 text-black rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-blue-500">
                <button onclick="sendMessage()" class="bg-blue-600 px-4 py-2 rounded-r-lg hover:bg-blue-500 transition">
                    Send
                </button>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        function sendMessage() {
            var userMessage = document.getElementById("userInput").value;
            if (!userMessage) return;

            var chatbox = document.getElementById("chatbox");
            chatbox.innerHTML += `<div class="text-right"><p class="bg-blue-600 inline-block px-3 py-2 rounded-lg text-white">${userMessage}</p></div>`;

            fetch("doctor_chat.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "message=" + encodeURIComponent(userMessage)
            })
            .then(response => response.text())
            .then(data => {
                chatbox.innerHTML += `<div class="text-left"><p class="bg-gray-200 inline-block px-3 py-2 rounded-lg text-gray-900">${data}</p></div>`;
                document.getElementById("userInput").value = "";
                chatbox.scrollTop = chatbox.scrollHeight;
            });
        }
    </script>

</body>
</html>

<?php
// Replace with your actual API key from Cohere
$api_key = "lGt1mTTnXT0sXGLQYRTgWXVQik7z01CVleHbOT4c";

// Check if user sent a message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_message = $_POST['message'];

    // API URL
    $url = "https://api.cohere.ai/v1/generate";

    // Request data
    $data = json_encode([
        "model" => "command", 
        "prompt" => "You are a doctor chatbot. A user asks: '$user_message'. Provide a medical response.",
        "max_tokens" => 100
    ]);

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $api_key",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute request
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode response
    $decoded = json_decode($response, true);
    echo $decoded["generations"][0]["text"] ?? "Sorry, I couldn't understand.";
} else {
    echo "No message received.";
}
?>

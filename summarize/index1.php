<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Text Summarizer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            text-align: center;
            padding: 20px;
        }
        textarea {
            width: 80%;
            height: 150px;
            margin: 20px 0;
            padding: 10px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .output {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>PHP Text Summarizer</h1>
    <form method="POST">
        <textarea name="text" placeholder="Enter text to summarize..."></textarea><br>
        <button type="submit">Summarize</button>
    </form>
    <div class="output">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
            $text = $_POST['text'];
            $apiKey = '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';

            // OpenAI API call
            $url = 'https://api.openai.com/v1/chat/completions';

            //$url = 'https://api.openai.com/v1/completions';
            $data = [
                'model' => 'gpt-3.5-turbo', // Updated model
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Summarize the following text:\n\n" . $text
                    ]
                ],
                'max_tokens' => 100,
                'temperature' => 0.7,
            ];
            

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo "Error: " . curl_error($ch);
            } else {
                $result = json_decode($response, true);
                echo "<pre>";
                print_r($result); // Print full API response for debugging
                echo "</pre>";

                if (isset($result['choices'][0]['text'])) {
                    echo "<strong>Summary:</strong> " . nl2br(htmlspecialchars(trim($result['choices'][0]['text'])));
                } else {
                    echo "Error: Unable to summarize text.";
                }
            }

            curl_close($ch);
        }
        ?>
    </div>
</body>
</html>

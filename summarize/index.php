<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Summarization</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Text Summarization</h1>
    <form method="POST">
        <textarea name="text" placeholder="Enter text to summarize..."></textarea><br>
        <button type="submit">Summarize</button>
    </form>
    <div class="output">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
            $text = $_POST['text'];
            $apiKey = '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'; // Replace with your token

            $url = 'https://api-inference.huggingface.co/models/facebook/bart-large-cnn';
            $data = json_encode(['inputs' => $text]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo "Error: " . curl_error($ch);
            } else {
                $result = json_decode($response, true);
                // echo "<strong>API Response:</strong><br><pre>";
                // print_r(json_decode($response, true));
                // echo "</pre>";
                if (isset($result[0]['summary_text'])) {
                    echo "<strong>Summary:</strong> " . htmlspecialchars($result[0]['summary_text']);
                } else {
                    echo "Error: Unable to summarize text. Check API response.";
                }
            }

            curl_close($ch);
        }
        ?>
    </div>
</body>
</html>

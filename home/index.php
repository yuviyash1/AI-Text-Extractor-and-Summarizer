<?php 
session_start();
if(!isset($_SESSION['firstname'])){
  header('Location: ../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image to Text Converter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../style/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tesseract.js/2.1.1/tesseract.min.js"></script>
</head>
<body>
<nav class="navbar">
  <div class="navbar-brand">
    <img src="../images/logo.png" alt="Logo">
  </div>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">AboutUs</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">ContactUs</a>
    </li>
  </ul>
  <div class="profile">
    <a href="../php/logout.php" class="nav-link">Logout</a>
    <div class="profile-img">
      <a href="../editprofile.php"><img src="../images/profile.png" alt="Profile"></a>
    </div>
  </div>
</nav>

<div class="name edit-name">
  <header style="text-align: center; ">welcome, <?php echo $_SESSION['firstname']; ?></header>
    
</div>
    <div class="container">
        <h1>Image to Text Converter</h1>
        <h4>By Sufi</h4>
        <input type="file" id="image-input" accept="image/*">
        <button id="extract-button">Extract Text</button>
        <div id="loading" class="hidden">Loading...</div>
        <h2>Extracted Text:</h2>
        <!-- <button id="extract-button">Clear</button> -->
        <button class="refresh-button" onclick="location.reload();">Clear</button>
        <button id="summarize" class="hidden" onclick="">Summarize</button>
        <form method="POST">
          <div class="output">
            <textarea id="output" name="output" rows="10" cols="50" placeholder="Extracted text will appear here..."></textarea>
          
            <!-- <h1>Text Summarization</h1> -->
            
            <!-- <textarea id="output" rows="10" cols="50" placeholder="Enter text to summarize..."></textarea><br> -->
          </div>
          <button type="submit">Summarize</button>
        </form>
        <div class="output">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['output'])) {
                $text = $_POST['output'];
                $apiKey = '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'; 

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
    </div>
</div>
    <script src="script.js"></script>
</body>
</html>
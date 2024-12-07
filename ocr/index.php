<?php 
session_start();
if(!isset($_SESSION['firstname'])){
  header('Location: ../index.php');
}

$extractedText = ''; // Variable to hold extracted text

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $imagePath = $_FILES['image']['tmp_name']; // Temporary file path
    $apiKey = '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'; // Replace with your Hugging Face API key
    $url = 'https://api-inference.huggingface.co/models/google/vit-base-patch16-224'; // New model endpoint

    // Prepare the image for upload
    $imageData = file_get_contents($imagePath);
    $base64Image = base64_encode($imageData);

    // Create the request payload
    $data = json_encode(['inputs' => $base64Image]);

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo "Error: " . curl_error($ch);
    } else {
        // Debugging: Print the raw response
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        
        $result = json_decode($response, true);
        if (isset($result[0]['generated_text'])) {
            $extractedText = htmlspecialchars($result[0]['generated_text']); // Store the extracted text
        } else {
            echo "Error: Unable to extract text. Check API response.";
        }
    }
    curl_close($ch);
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
  <header style="text-align: center;">Welcome, <?php echo $_SESSION['firstname']; ?></header>
</div>

<div class="container">
    <h1>Image to Text Converter</h1>
    <h4>By Sufi</h4>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Extract Text</button>
    </form>
    <h2>Extracted Text:</h2>
    <div class="output">
        <textarea id="output" name="output" rows="10" cols="50" placeholder="Extracted text will appear here..."><?php echo $extractedText; ?></textarea>
    </div>
</div>
</body>
</html>
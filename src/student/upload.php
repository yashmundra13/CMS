<?php
$title = $_POST["assignmentTitle"];
$userName = $_POST["userName"];
$date =  $date = date('Y-m-d H:i:s');
$id = $_POST["assignmentId"];
$target_dir = "uploads/".$title.$id."/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$target_file = $target_dir.$userName." - ".$date." " . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. To return: <a href='./home.php'>Press here</a>";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>



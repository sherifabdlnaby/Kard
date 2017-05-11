
<?php

    // configuration
    require("../includes/config.php");
?>

<?php
$target_dir = "uploads/";
$_FILES["fileToUpload"]["name"] = preg_replace('/\s+/', '', $_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    apologize("File is too large!");
}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    apologize("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    apologize("Sorry, your file was not uploaded.");
    
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        CS50::query("UPDATE account SET img = ? WHERE id = ?", $target_dir.$_FILES["fileToUpload"]["name"], $_SESSION["id"]);
        if($_SESSION["complete1"]) redirect("/photo.php");
        else { $_SESSION["complete1"]=1; redirect("/");}
    } else {
        apologize("Sorry, your file was not uploaded.");
    }
}

?>
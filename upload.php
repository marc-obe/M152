<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        switch ($imageFileType) {
            case "png":
                $im_php = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
                break;
            case "jpeg":
            case "jpg":
                $im_php = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
                break;
            case "webp":
                $im_php = imagecreatefromwebp($_FILES["fileToUpload"]["tmp_name"]);
                break;
            default:
               $im_php = imagecreatefromjpeg("teapot.jpg");
        }
        $im_php = imagescale($im_php, -1, 300);
        $sizeX = imagesx($im_php);
        $im_php = imagecrop($im_php, ['x' => ($sizeX - 300) / 2, 'y' => 0, 'width' => 300, 'height' => 300]);

        imageWebP($im_php, "bild.png", 80);
        header("Location: http://localhost/m152");
        exit;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}


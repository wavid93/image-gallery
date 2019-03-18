<?php




class IndexController extends Zend_Controller_Action
{
    private $imageModel;
    private $db;

    //Initialize controller
    public function init()
    {
        $this->imageModel = new Application_Model_DbTable_Image();
        $this->db = $this->imageModel->getDbConfig();
    }

    //Main controller function
    public function indexAction()
    {
        //Send image data to view
        $sql= "SELECT image,id,views,downloads FROM images ORDER BY dateTime DESC";
        $result= $this->db->query($sql);

        foreach($result as $row){
            $data[] = $row;
        }

        $this->view->data = $data;

        //Actions
        if (isset($_POST["submit"])) {
            $this->uploadImage();
        }
        else if (isset($_POST["download"])) {
            $this->downloadImage();
        }
        else if (isset($_POST["actionView"])) {
            $this->viewImage($_POST["actionView"]);
        }

    }

    //Get image from local folder through img ID reference
    private function viewImage($imgID)
    {
        $imgUrl = $this->db->query("SELECT image FROM images WHERE id = '$imgID'");
        $res = mysqli_fetch_array($imgUrl);
        $this->imageModel->updateViews($imgID);
        header('Location: uploads/'.$res["image"]);
    }

    //Download image to local computer
    private function downloadImage()
    {

        $imageID = $_POST["imageID"];
        $sql= "SELECT image FROM images WHERE id = '$imageID'";

        $results = $this->db->query($sql);
        $fileName = mysqli_fetch_array($results);
        $imageName = $fileName["image"];
        $url = "uploads/".$fileName["image"];

        if (is_file($url)) {

            $size = filesize($url);
            if (function_exists('mime_content_type')) {
                $type = mime_content_type($url);
            } else if (function_exists('finfo_file')) {
                $info = finfo_open(FILEINFO_MIME);
                $type = finfo_file($info, $url);
                finfo_close($info);
            }
            if ($type == '') {
                $type = "application/force-download";
            }

            //Increment downloads value
            $this->imageModel->updateDownloads($imageID);

            header("Content-Type: $type");
            header("Content-Disposition: attachment; filename=$imageName");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . $size);
            // Download img
            readfile("http://localhost/" . "$url");
            die();

        } else {
            die("El archivo no existe.");
        }
    }

    //Upload image from local computer
    private function uploadImage()
    {
        $checkImageSelected = getimagesize($_FILES["image"]["tmp_name"]);

        if ($checkImageSelected !== false) {

            $this->check_valid_image($_FILES);

            $title = $_POST["title"] ? $_POST["title"] : "";
            $nombre_img = $_FILES['image']['name'];
            $directorio = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
            //Move img from tmp folder to specific project folder
            move_uploaded_file($_FILES['image']['tmp_name'],$directorio.$nombre_img);

            //Insert image content into database
            $data = array(
                "title" => $title,
                "image" => $nombre_img,
            );
            $insert = $this->imageModel->create($data);

            if ($insert) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                echo "File uploaded successfully.";

            } else {
                echo "File upload failed, please try again.";
            }
        } else {
            echo "Please select an image file to upload.";
        }
    }

    //Check image data
    private function check_valid_image( $file ) {

        //Check mimetype
        $allowed_mimetypes = array('image/jpeg', 'image/png');

        if (!in_array($file['image']['type'], $allowed_mimetypes)){
            return $file;
        }

        //Check Size
        $image = getimagesize($file['image']['tmp_name']);

        $maximum = array(
            'width' => '1000',
            'height' => '1000'
        );

        $image_width = $image[0];
        $image_height = $image[1];

        $too_large = "Image dimensions are too large. Maximum size is {$maximum['width']} by {$maximum['height']} pixels. Uploaded image is $image_width by $image_height pixels.";

        if ( $image_width > $maximum['width'] || $image_height > $maximum['height'] ) {
            //add in the field 'error' of the $file array the message
            die($too_large);
        }else {
            return true;
        }
    }

}


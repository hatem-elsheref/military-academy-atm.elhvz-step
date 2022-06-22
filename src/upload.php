<?php

define('TANSIK', 'SCN');

function upload($file, $date){
    $allowed = ['xlsx'];
    $file_name_parts = explode('.', $file['name']);
    $file_name = $file_name_parts[0];
    $file_extension = end($file_name_parts);
    if(in_array($file_extension, $allowed)){
        $dir_path = "storage" . DIRECTORY_SEPARATOR . TANSIK . DIRECTORY_SEPARATOR . $date;
        shell_exec("mkdir $dir_path");
        return move_uploaded_file($file['tmp_name'], $dir_path . DIRECTORY_SEPARATOR . strtolower($date . '.' . $file_extension)) ? 
        "File Uploaded Successfully!" : "Filed To Upload File Try Again!";
    }else{
        return "Failed, Only .xlsx Files Are Allowed To Upload";
    }
}
if(isset($_POST['upload'])){
   
    if(isset($_POST['date']) && !empty($_POST['date']) && !empty($_FILES['file']) && $_FILES['file']['error'] == 0){
       // upload file here but ensure the file type is xlsx
       $result = upload($_FILES['file'], $_POST['date']);
    }else{
        $errors = [];
        $errors['message'] = "Please Upload File And Select Date";
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Tansik</title>
  </head>
  <body>
    
    <div class="container">
    <div class="row mt-5">
    <a href="/upload.php" class="btn btn-sm btn-warning">Upload</a>
    <a href="/main.php" class="btn btn-sm btn-info ml-2">Main</a>
    <a href="/relatives.php" class="btn btn-sm btn-danger ml-2">Relatives</a>
    </div>
      <div class="row mt-5">
      <div class="col-sm-12">
      <?php if(isset($errors)):?>
      <div class="alert alert-danger">
       <strong>
        <?=$errors['message'];?>
        </strong>
      </div>
<?php endif;?>

<?php if(isset($result) && !empty($result)):?>
      <div class="alert alert-success">
       <strong>
        <?=$result;?>
        </strong>
      </div>
<?php endif;?>
      <h1>Prepare Atm Elhvz Step</h1>
      <hr>
        <form method="post" action="/upload.php" enctype="multipart/form-data">
             <div class="row">
                <div class="col">
                    <input type="file" name="file" accept=".xlsx"  class="form-control" placeholder="الملف">
                </div>
                <div class="col">
                    <input type="date" name="date" class="form-control" placeholder="عن يوم">
                </div>
                </div>
                <div class="row mt-3">
                <div class="col">
                   <button type="submit" name="upload" class="form-control btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
  </body>
</html>


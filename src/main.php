<?php

require_once '../vendor/autoload.php';
define('TANSIK', 'SCN');
define('ROWS', 1000);
define('SHEET', 's1');

if(isset($_GET['date']) && !empty($_GET['date'])){
    $file_path = "storage" . DIRECTORY_SEPARATOR . TANSIK . DIRECTORY_SEPARATOR . $_GET['date'] . DIRECTORY_SEPARATOR . strtolower($_GET['date'] . '.xlsx');
    $page = isset($_GET['page']) && is_int((int)$_GET['page']) ? $_GET['page'] : 1;


    if(file_exists($file_path)){
        /** Create a new Xls Reader  **/
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        /** Load $inputFileName to a Spreadsheet Object  **/
        $reader->setLoadSheetsOnly(SHEET);
        $spreadsheet = $reader->load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $header = $rows[0];
        $rows = array_splice($rows, 1);
        $number_of_pages = ceil(count($rows) / ROWS);

        $chunks = array_chunk($rows, ROWS);

        $currentChunk = $chunks[$page - 1] ?? [];

        
    }else{
        $error = "File Not Found";
        $currentChunk = [];
        $header = [];
    }
}else{
    // header('Location: /index.php');
    $currentChunk = [];
    $header = [];
 
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

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
      <?php if(isset($error) && !empty($error)):?>
      <div class="alert alert-danger">
       <strong>
        <?=$error;?>
        </strong>
      </div>
<?php endif;?>

<h1>Prepare Atm Elhvz Step - <span class="text-danger">Main</span></h1>
      <hr>
        <form method="get" action="/main.php">
             <div class="row">
                <div class="col">
                    <input type="date" name="date" value="<?=$_GET['date']?>" class="form-control" placeholder="عن يوم">
                </div>
                <div class="col">
                   <button type="submit" name="find" class="form-control btn btn-primary">Find</button>
                </div>
                </div>
        </form>
       
  <?php
if(isset($page) && isset($number_of_pages) && isset($_GET['date'])):
    $prev = $page == 1 ? '#' : '/main.php?date=' . $_GET['date'] . '&page=' . ($page - 1);
    $next = $page == $number_of_pages ? '#' : '/main.php?date=' . $_GET['date'] . '&page=' . ($page + 1);
?>
 <hr>
 <nav aria-label="Page navigation example">

  <ul class="pagination">

    <li class="page-item">

      <a class="page-link"  href="<?=$prev?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php if(!empty($currentChunk)):?>
     

    <?php foreach(range(1, $number_of_pages) as $p):?>
    <li  class="page-item <?= $page == $p ? 'active' : ''?>" ><a class="page-link" href="<?="/main.php?date=" . $_GET['date'] . '&page=' . $p?>"><?=$p?></a></li>
    <?php endforeach?>
    <?php endif;?>
    <li class="page-item">
      <a class="page-link" href="<?=$next?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
<?php endif;?>
</nav>
<hr>
        <table>
        <thead>
        <tr>
        <?php foreach($header as $key => $value):?>
        <th><?=$value?></td>
        <?php endforeach;?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($currentChunk as $index => $row):?>
    
        <tr>
        <td><?=$row[0]?></td>
        <td><?=$row[1]?></td>

        </tr>
<?php endforeach;?>
        </tbody>
        </table>
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
    <!-- <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>


    <script>
    $(document).ready( function () {
        $('.buttons-copy').on('click', function(){
       
        
        alert('copied !!')
    })
        $('table').DataTable({
            sort:false,
            order:false,
            paging:false,
            dom: 'Bfrtip',
            
            buttons: [
                {
                extend: 'copyHtml5',
                title: '',
                 }
                // 'copyHtml5',
                // 'excelHtml5',
                // 'csvHtml5',
                // 'pdfHtml5'
            ]
        });
    } );

    
</script>
  </body>
</html>


<?php
require_once 'bootstrap.php';
$a_flow = range( 1, 20 );

if ( isset( $_POST[ 'submit-pause' ] ) or isset( $_POST[ 'submit-cancel' ] ) )
{
  $status = ( isset( $_POST[ 'submit-pause' ] ) ) ? 'pause' : 'cancel';

  $sql = "UPDATE `allo_parser` SET `parser_status` = :status WHERE `parser_id` = :id";

  DB::query( $sql, ['status' => $status, 'id' => $data_parser['parser_id']] );
  setSuccess( 'Парсер ' . ( ( $status == 'pause' ) ? 'на паузе' : 'отменен' ) );
  exit( header( 'Location: index.php' ) );
}

if ( isset( $_POST[ 'submit-start' ] ) )
{
  $a_data  = $a_error = [];
  $a_data[ 'flow' ] = ( isset( $_POST[ 'flow' ] ) and is_string( $_POST[ 'flow' ] ) ) ? trim( $_POST[ 'flow' ] ) : '';

  if ( ! in_array( $a_data[ 'flow' ], $a_flow ) )
    $a_error[ 'flow' ] = 'Виберіть значення зі списку';

  //4
  if ( ! $a_error )
  {
    $sql = "UPDATE `allo_parser` SET `parser_flow` = :flow, `parser_status` = 'process' WHERE `parser_id` = :id";

    DB::query( $sql, ['flow' => $a_data['flow'], 'id' => $data_parser['parser_id']] );
    setSuccess( 'Парсер запущен' );
    exit( header( 'Location: index.php' ) );
  }
  else
    setInfo( 'В даних знайдено помилки:' );
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Parser Allo.ua</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <body>
    <?php getInfoBlock() ?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <form action="" method="post">
            <?= ( ( isset( $a_error[ 'flow' ] ) ) ? '<span class="text-danger">' . $a_error[ 'flow' ] . '</span><br />' : '' ) ?>
            Потоки:
            <select name="flow">
              <?php foreach ( $a_flow as $flow ): ?>
              <option value="<?= $flow ?>"<?= ( ( isset( $data_parser[ 'parser_flow' ] ) and $data_parser[ 'parser_flow' ] == $flow ) ? ' selected="selected"' : '' ) ?>><?= $flow ?></option>
              <?php endforeach ?>
            </select>


            <input type="submit" class="btn btn-success btn-sm" name="submit-start" value="Start" />
            <input type="submit" class="btn btn-warning btn-sm" name="submit-pause" value="Pause" />
            <input type="submit" class="btn btn-danger btn-sm" name="submit-cancel" value="Cancel" />
          </form>

        </div>
        <div class="col-md-12">
          <h5>Log</h5>
          <textarea style="width: 100%; height: 400px" id="log"></textarea>
        </div>
        <div class="col-md-12">
          <h5>History</h5>

          <?php
          $sql = "SELECT * FROM `allo_parser`";
          $data = $stm = DB::query( $sql );

          foreach ( $data as $row ): ?>
          <h4><?= $row['parser_id'] ?>(<?= $row['parser_status'] ?>)</h4>
          <a href="download.php?type=csv&id=<?= $row['parser_id']?>">Download CSV</a>
          <a href="download.php?type=xls&id=<?= $row['parser_id']?>">Download XLS</a>
          <hr />
          <?php endforeach ?>
        </div>

      </div>
    </div>
    <script>
      <?php if ( $data_parser['parser_status'] == 'process' ): ?>

        $( function () {
          var streams = <?= $data_parser['parser_flow'] ?>;

          var seq = new Array();
          for (i=1; i<50000; i++) {
            seq.push(i);
          }

          var finishCount = 0;
          logArea = $('#log');
          close = false;

          finishCallback = function(){
            alert('To many errors');
          }

          function go(i){
            if(seq.length) {
              $.ajax({
                method: 'GET',
                url: 'parser.php?n='+seq.shift(),

                success: function ( resp ) {
                  console.log( resp + ' // ' + i );

                  logArea.append( resp + "\n" );
                  go(i);
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                  console.log(errorThrown)

                  if ( errorThrown == 'Grabb complete' )
                    return window.location.href = '';

                  console.log( 'Stop streem: #' + i );
                  logArea.append( errorThrown + "\n" );
                }
              });
            }
            else
            {
              finishCount++;
              if(finishCount==streams) {finishCallback();}
            }
          }

          for (i=0; i<streams; i++) {
            go(i);
          }
        });

      <?php endif ?>
    </script>
  </body>
</html>
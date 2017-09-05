<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
    <h1>JS</h1>
    <button onclick="loadGet()">Get</button>
    <button onclick="loadPost()">Post</button>
    <h1>JQUERY</h1>
    <button id="get">Get</button>
    <button id="post">Post</button>
    <button id="ajax">Ajax</button>
    <h1>TEST</h1>
    <button id="getList">GetList</button>
    <hr />
    <div id="content"></div>
    <hr />
    <h4>Добавить файл</h4>
    <form id="add">
      <input type="text" name="file_name" />
      <input type="submit" />
    </form>
    <script>
      function loadGet() {
        var xhr = new XMLHttpRequest();
        xhr.open( "GET", 'req.php?get=true&foo=1&bar=22', true );
        xhr.send();

        xhr.onreadystatechange = function () { // (3)
          if ( xhr.readyState != 4 )
            return;

          if ( xhr.status != 200 ) {
            alert( xhr.status + ': ' + xhr.statusText );
          } else {
            alert( xhr.responseText );
          }
        }
      }

      function loadPost() {
        var xhr = new XMLHttpRequest();

        xhr.open( "POST", 'req.php?a=1', true )
        xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' )
        xhr.send( 'post=true&foo=111&bar=333' );

        xhr.onreadystatechange = function () {
          if ( xhr.readyState != 4 )
            return;

          if ( xhr.status != 200 ) {
            alert( xhr.status + ': ' + xhr.statusText );
          } else {
            alert( xhr.responseText );
          }
        }
      }

      $( document ).ready( function () {
        $( '#get' ).on( 'click', function () {
          $.get( 'req.php', { foo: 432, bar: 543543 }, function ( resp ) {
            alert( resp );
          } );
        } );

        $( '#post' ).on( 'click', function () {
          $.post( 'req.php', { post2222: 'jquery', foo: 432, bar: 543543 }, function ( resp ) {
            alert( resp );
          } );
        } );

        $( '#ajax' ).on( 'click', function () {
          $.ajax( {
            url: 'req.php?get=test',
            method: 'POST',
            //dataType: 'json',
            data: { ajax: 'true', foo: 432, bar: 543543 },
            success: function ( resp ) {
              alert( resp );
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
              alert( 'Error' );
            }
          } );
        } );

        $( '#add' ).on( 'submit', function ( e ) {
          e.preventDefault();

          $.post( 'data.php', $( '#add' ).serialize() + '&type=add', function ( resp ) {
            if ( resp.status == 0 )
            {
              alert( resp.info );

              $.each( resp.error, function ( a, b ) {
                $( '#add' ).find( 'input[name="' + a + '"]' ).css( 'border', '1px solid red' ).after( $( '<div />' ).text( b ) );
              } );

              return false;
            }

            alert( resp.info );
            addListElement( $( '#add' ).find( 'input[name="file_name"]' ).val() );
          }, 'json' );
        } );

        $( '#getList' ).on( 'click', function () {
          $.post( 'data.php', { type: 'getlist' }, function ( resp ) {
            $( '#content' ).empty();

            $.each( resp, function ( a, b ) {
              addListElement( a, b );
            } );
          }, 'json' );
        } );

        $( document ).on( 'click', '.deleteFile', function () {
          name = $(this).attr('data-id');
          box = $(this).parent().parent();

          $.post( 'data.php', { type: 'delete', file_name: name }, function ( resp ) {
            if ( resp.status == 0 )
              return alert( resp.info );

            alert( resp.info );
            box.remove();
          }, 'json' );
        });

        $( document ).on( 'submit', '.editFile', function (e) {
          e.preventDefault();
          form = $(this);

          $.post( 'data.php', form.serialize() + '&type=edit', function ( resp ) {
            if ( resp.status == 0 )
            {
              alert( resp.info );

              $.each( resp.error, function ( a, b ) {
                form.find( 'input[name="' + a + '"]' ).css( 'border', '1px solid red' ).after( $( '<span />' ).attr( 'title', b ).text('[i]'));
              } );

              return false;
            }

            alert( resp.info );
          }, 'json' );
        });

        function addListElement( file, content )
        {
          var box = '<div style="border: 1px solid red; padding: 5px;">\
                      <div style="display: inline-block; width: 250px;">File: ' + file + '</div>\
                      <div style="display: inline-block;">\
                        <form class="editFile">\
                          <input type="text" name="file_content" value="' + content + '" />\
                          <input type="hidden" name="file_name" value="' + file + '" />\
                          <input type="submit" value="Редактировать" />\
                        </form>\
                      </div>\
                      <div style="display: inline-block;"><button data-id="' + file + '" class="deleteFile">Удалить</button></div>\
                    </div>';

          $( '#content' ).append( box );
        }
      } );
    </script>
  </body>
</html>
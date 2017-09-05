<?php
require_once 'bootstrap.php';

echo '<script
			  src="https://code.jquery.com/jquery-3.1.1.min.js"
			  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
			  crossorigin="anonymous"></script>';
echo '<script
			  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
			  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
			  crossorigin="anonymous"></script>';

echo '<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />';

getInfoBlock(  );

?>

<div id="posts"></div>

<?php if ( isset( $_SESSION['auth'] ) ): ?>
<div id="add-info"></div>
<form action="" method="post" id="add-form">
  <label>Заголовок</label><br />
  <input type="text" name="blog_title" /><br />
  <label>Текст записи</label><br />
  <textarea name="blog_text"></textarea><br />

  <input type="hidden" name="token" value="<?= session_id(  ) ?>" />
  <input type="submit" id="add" value="Добавить запись в блог" />
</form>


<div id="edit-box" style="display: none">
  <div id="edit-info"></div>
  <form action="" method="post" id="edit-form">
    <label>Заголовок</label><br />
    <input type="text" id="title" name="blog_title" /><br />
    <label>Текст записи</label><br />
    <textarea id="text" name="blog_text"></textarea><br />

    <input type="hidden" id="blog-id" name="blog_id" />
    <input type="hidden" name="token" value="<?= session_id() ?>" />
    <input type="submit" id="edit" value="Редагувати" />
  </form>
</div>
<?php endif ?>


<script>
  $( document ).ready( function(  ){
    token = '<?= session_id(  ) ?>';

    $(document).on('click', '.edit', function(e){
      e.preventDefault();
      var id = $(this).attr('data-id');
      var box = $(this).closest('div');

      $('#edit-box').dialog();
      $('#blog-id').val(id)
      $('#title').val(box.find('h2').text())
      $('#text').text(box.find('div').text())
    });

    $(document).on('click', '#edit', function(e){
      e.preventDefault();
      $('#edit-info').text('');
      $('.errors').remove();


      $.ajax( {
          url: 'ajax.php?action=edit',
          data: $('#edit-form').serialize(),
          dataType: 'json',
          method: 'post',
          error: function ( jqXHR ) {
            alert( jqXHR.responseText );
          },
          success: function ( json ) {
            if ( json.status == '1' )
            {
              alert(json.result.text);
    //          window.location.href = '';

              var box = $('.post[data-id="'+ $('#blog-id').val() +'"]');
              box.find('h2').text( $('#title').val() );
              box.find('div').text( $('#text').val() );
              $('#edit-box').dialog('close');

              $('#edit-form')[0].reset();
            }
            else
            {
              $('#edit-info').text(json.info);

              $.each(json.error, function(a,b){
                $('<div />').addClass('errors').text(b).insertAfter( $('#edit-form').find('[name="'+a+'"]') );
              });
            }
          }
        } );
    });

    $(document).on('click', '.delete', function(e){
      e.preventDefault();
      var id = $(this).attr('data-id');
      var box = $(this).closest('div');

      if ( confirm('Удалить?') )
      {
        $.post( 'ajax.php?action=delete', {blog_id: id, token: token}, function( resp ){
        if ( resp.status == '1')
        {
          box.slideUp(1000);
        }
        else
        {
          alert(resp.info);
        }
      }, 'json');
      }
    });

    $(document).on('click', '#add', function(e){
      e.preventDefault();
      $('#add-info').text('');
      $('.errors').remove();

      $.post( 'ajax.php?action=add', $('#add-form').serialize(), function( resp ){
        if ( resp.status == '1')
        {
          $('#add-info').text(resp.result.text);
           var div = $('<div />').addClass('post').attr('data-id', resp.data.blog_id)
              .append( $( '<h2 />').text(resp.data.blog_title) )
              .append( $( '<a />').attr('href', '#').text('Редактировать ').addClass('edit').attr('data-id',resp.data.blog_id) )
              .append( $( '<a />').attr('href', '#').addClass('delete').attr('data-id',resp.data.blog_id).text('Удалить') )
              .append( $( '<div />').text(resp.data.blog_text) )
              .append( $( '<hr />') );

          $('#posts').append( div.show(1500) );
          $('#add-form')[0].reset();
        }
        else
        {
          $('#add-info').text(resp.info);

          $.each(resp.error, function(a,b){
            $('<div />').addClass('errors').text(b).insertAfter( $('#add-form').find('[name="'+a+'"]') );
          });
        }
      }, 'json');
    });

    $.get( 'ajax.php', {action:'index_json'}, function( resp ){
      if ( resp.status == 1 )
      {
        $.each(resp.result, function(a,b){
          var div = $('<div />').addClass('post').attr('data-id', b.blog_id)
              .append( $( '<h2 />').text(b.blog_title) )
              .append( $( '<a />').attr('href', '#').text('Редактировать ').addClass('edit').attr('data-id',b.blog_id) )
              .append( $( '<a />').attr('href', '#').addClass('delete').attr('data-id',b.blog_id).text('Удалить') )
              .append( $( '<div />').text(b.blog_text) )
              .append( $( '<hr />') );

          $('#posts').append( div.show(1500) );
        });
      }
      else
        alert( resp.info );
    }, 'json' );
  } );
</script>
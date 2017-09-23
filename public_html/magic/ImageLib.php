<?php
class ImageLib
{
  protected $_image  = NULL;
  protected $_prefix = 'IMG';
  protected $_width  = NULL;
  protected $_height = NULL;
  protected $_tmp    = NULL;

  public function __construct ( $image )
  {
    if ( file_exists( $image ) )
    {
      $this -> _image  = $image;
      list($this -> _width, $this -> _height) = getimagesize( $image );
    }
    else
      throw new Exception( 'File not found. Aborting.' . $image);

    $this -> _tmp = 'files/' . $this -> _prefix . rand();
    copy( $this -> _image, $this -> _tmp );
  }

  public function toPng(  )
  {
    $this -> execute( "convert -verbose -coalesce {$this -> _tmp} -delete 1--1 {$this -> _tmp}" );
    return $this;
  }

  public function save( $path )
  {
    rename( $this -> _tmp, $path );
  }

  public function execute ( $command )
  {
    $command = str_replace( array ( "\n", "'" ), array ( '', '"' ), $command );
    $command = escapeshellcmd( $command );
    exec( $command );
  }

  public function colortone ( $input, $color, $level, $type = 0 )
  {
    $args[0] = $level;
    $args[1] = 100 - $level;
    $negate  = $type == 0 ? '-negate' : '';

    $this -> execute( "convert
        {$input}
        ( -clone 0 -fill '{$color}' -colorize 100% )
        ( -clone 0 -colorspace gray {$negate} )
        -compose blend -define compose:args={$args[0]}{,$args[1]} -composite
        {$input}" );
  }

  public function border ( $input, $color = 'black', $width = 20 )
  {
    $this -> execute( "convert {$input} -bordercolor {$color} -border {$width}x{$width} {$input}" );
  }

  public function frame ( $input, $frame )
  {
    $this -> execute( "convert {$input} ( '{$frame}' -resize {$this -> _width}x{$this -> _height}! -unsharp 1.5×1.0+1.5+0.02 ) -flatten {$input}" );
  }

  public function vignette ( $input, $color_1 = 'none', $color_2 = 'black', $crop_factor = 1.5 )
  {
    $crop_x = floor( $this -> _width * $crop_factor );
    $crop_y = floor( $this -> _height * $crop_factor );

    $this -> execute( "convert
        ( {$input} )
        ( -size {$crop_x}x{$crop_y}
        radial-gradient:{$color_1}-{$color_2}
        -gravity center -crop {$this -> _width}x{$this -> _height}+0+0 +repage )
        -compose multiply -flatten
        {$input}" );
  }

  public function espedal ()
  {
    $this -> execute( "convert {$this -> _tmp} -modulate 120,10,100 -fill '#222b6d' -colorize 20 -gamma 0.5 -contrast -contrast {$this -> _tmp}" );
    //$this -> border( $this -> _tmp );
    return $this;
  }

  public function orf ()
  {
    $this -> colortone( $this -> _tmp, '#330000', 100, 0 );

    $this -> execute( "convert {$this -> _tmp} -modulate 150,80,100 -gamma 1.2 -contrast -contrast {$this -> _tmp}" );

    $this -> vignette( $this -> _tmp, 'none', 'LavenderBlush3' );
    $this -> vignette( $this -> _tmp, '#ff9966', 'none' );
    //$this->border($this->_tmp, 'white');
    return $this;
  }

  public function cherokee ()
  {
    $this -> colortone( $this -> _tmp, '#222b6d', 100, 0 );
    $this -> colortone( $this -> _tmp, '#f7daae', 100, 1 );

    $this -> execute( "convert {$this -> _tmp} -contrast -modulate 100,150,100 -auto-gamma {$this -> _tmp}" );
    $this -> frame( $this -> _tmp, __FUNCTION__ );
    return $this;
  }

  public function panio ()
  {
    $command = "convert {$this -> _tmp} -channel R -level 33% -channel G -level 33% {$this -> _tmp}";

    $this -> execute( $command );
    $this -> vignette( $this -> _tmp );
    return $this;
  }

  public function greys ()
  {
    $command = "convert '{$this -> _tmp}' -channel RGBA -matte -colorspace gray '{$this -> _tmp}'";
    $this -> execute( $command );
    return $this;
  }

  public function sepia ()
  {
    //convert c.jpg 1.jpg
    $command = "convert '{$this -> _tmp}' -set colorspace RGB -sepia-tone 80% '{$this -> _tmp}'";
    $this -> execute( $command );
    return $this;
  }

  function resize ( $width = false, $height = false )
  {
    if ( $width > 0 and $height > 0 )
      $newSize = $this -> getSizeByFramework( $width, $height );

    else if ( $width and $width > 0 )
      $newSize = $this -> getSizeByWidth( $width );

    else if ( $height and $height > 0 )
      $newSize = $this -> getSizeByHeight( $height );

    else
      $newSize = [$this -> _width, $this -> _height];

    $this -> execute( "convert -resize {$newSize[0]}x{$newSize[1]} -quality 80 {$this -> _tmp} {$this -> _tmp}" );
    list( $this -> _width, $this -> _height ) = $newSize;
    return $this;
  }

  private function getSizeByFramework ( $width, $height )
  {
    if ( $this -> _width <= $width and $this -> _height <= $height )
      return array ( $this -> _width, $this -> _height );

    if ( $this -> _width / $width > $this -> _height / $height )
      return [$width, round( $this -> _height * $width / $this -> _width )];
    else
      return [round( $this -> _width * $height / $this -> _height ), $height];
  }

  private function getSizeByWidth ( $width )
  {
    if ( $width >= $this -> _width )
      return [$this -> _width, $this -> _height];

    return [$width, round( $this -> _height * $width / $this -> _width )];
  }

  private function getSizeByHeight ( $height )
  {
    if ( $height >= $this -> _height )
      return [$this -> _width, $this -> _height];

    return [round( $this -> _width * $height / $this -> _height ), $height];
  }

  public function getSize ()
  {
    return [$this -> _width, $this -> _height];
  }

}

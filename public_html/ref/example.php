<?php
require_once 'Product/Products.php';
require_once 'Basket/Basket.php';
require_once 'Power/Power.php';
require_once 'Ref/FFs.php';



$beer1 = new Beer( 'Stella Artois', 4 );
$beer2 = new Beer( 'BUD', 1 );
$beer3 = new Beer( '1715', 2 );

$milk1 = new Milk( 'Молокия', 2 );
$milk2 = new Milk( 'Простоквасимо', 3 );

echo '<pre>';
print_r( $beer1 );
echo '</pre>';
echo '<pre>';
print_r( $beer2 );
echo '</pre>';
echo '<pre>';
print_r( $beer3 );
echo '</pre>';
echo '<pre>';
print_r( $milk1 );
echo '</pre>';
echo '<pre>';
print_r( $milk2 );
echo '</pre>';


$basket1 = new Basket();
$basket1 -> setProduct( $beer1 );
$basket1 -> setProducts( [
  $beer2, $milk1
] );

echo '<pre>';
print_r( $basket1 -> getProducts() );
echo '</pre>';




$basket2 = new Basket();
$basket2 -> setProducts( [
  $beer3, $milk2
] );

echo '<pre>';
print_r( $basket2 -> getProducts() );
echo '</pre>';

Power::off();
echo ( Power::getPower() ) ? 'Эл.вкл.' : 'Эл.выкл!';

echo '<hr />';

Power::on();
echo ( Power::getPower() ) ? 'Эл.вкл.' : 'Эл.выкл!';

echo '<hr />';
$ariston = new Ariston; //Freezer
$Indesit = new Indesit; //FF
$atlant  = new Atlant;  //Fridge

$ariston -> setProduct( $beer1 );
$ariston -> setProducts( [$beer3, $milk2] );
$ariston -> setbasket( $basket1 );
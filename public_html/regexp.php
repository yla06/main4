<?php
//dS1o6Z6o5a
//
//
//
//
//
//
//  
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//2017-10-01

//$date = '2017-02-28';
//
//if ( preg_match( '#^\d{4}\-\d{2}\-\d{2}$#', $date ) )
//{
//  list( $y, $m, $d ) = explode( '-', $date );
//
//  if ( checkdate( $m, $d, $y ) )
//    echo 'ok';
//  else
//    echo '!ok';
//}
//else
//  echo 'Date incorrect';

//var_dump( preg_match( '#(\d{4})\-(\d{2})\-(\d{2})#', 'hjsdahkjsd 2000-11-28 sdahkjsd 2017-02-28 gf g gfgfgf', $match ) );
//var_dump( preg_match_all(
//  '#(\d{4})\-(\d{2})\-(\d{2})#',
//  'hjsdahkjsd 2000-11-28 sdahkjsd 2017-02-28 gf g gfgfgf',
//  $match,
//  PREG_PATTERN_ORDER
//) );

//echo '<pre>';
//print_r( $match );
//echo '</pre>';


//preg_match_all( '#^(?:\+38)?\(0(?:5(?:0|1)|6(?:3|6|8)|9[356789])\)[\d]{7}$#', '(063)6099344', $m );

//echo preg_replace( '#(\d{4})\-(\d{2})\-(\d{2})#', '<b>${3}.$2.\\1</b>', $string );











//$string = 'foo 2017-10-09 baz 9999-99-12 11aa 2000-11-12 fd 2017-02-30 fds';
//echo preg_replace_callback( '#(\d{4})\-(\d{2})\-(\d{2})#', 'mf_date_replace', $string );
//
//function mf_date_replace( $match )
//{
//  if ( ! checkdate( $match[2], $match[3], $match[1] ) )
//    return $match[0];
//  //   2017-10-09 <     2017-10-04
//  if ( $match[0] < date( 'Y-m-d' ) )
//  {
//    return "<span style=\"color: red; font-weight: 900\">{$match[3]}.{$match[2]}.{$match[1]}</span>";
//  }
//  else
//    return "<span style=\"color: green; text-decoration: underline\">{$match[3]}.{$match[2]}.{$match[1]}</span>";
//}


//
//$text = "Мене сьогодні довели до сказу. Олігархи добилися того, що НКРЄ під"
//  . " прямим підпорядкуванням президента. Отже, тарифи - його ідея. ми бачимо, "
//  . "що не за те стояли на Майдані! Пропало все. З такою політикою, як пропонує "
//  . "цей Меморандум з МВФ, сплюндровано найголовніші цінності, і на цьому гріють"
//  . " руки спекулянти, продажні політики, та інші. Шановні народні депутати"
//  . " України! ::4:: З такою політикою, як пропонує цей ::12:: Меморандум з МВФ, депутатам, "
//  . "чесно кажучи, байдуже, як живуть люди, і то ж доки триватиме "
//  . "така \"дипломатична шизофренія\" нашої влади? Звертаюся до президента "
//  . "України Петра Порошенка особисто. Внаслідок зубожіння українського "
//  . "народу значно впала купівельна спроможність зубожілого населення і, як "
//  . "наслідок, , чи вони розуміють що таке гріх? Пропало все. Паршиві шанолюбці, "
//  . "національне сміття, паразити й злодії повторюють погані діла дідів-поганців, "
//  . "та патріотів зливають у казанах. Годі героїзму в телевізорі! Десь там"
//  . " стріляють одні в одних сірі, убогі люди, терпець урвався остаточно, і "
//  . "треба зупинити це негайно, ::17:: і зараз я скажу, яким чином. Розкололи націю "
//  . "жлобством! На сьогоднішнім засіданні Верховної Ради України обговорювали "
//  . "питання, що повторюють погані діла дідів-поганців, та патріотів зливають"
//  . " у казанах. Пропало все. В Україні дотлівають в попелі"
//  . " рештки \"руского міра\", Україна ще надовго залишиться бідною, сировинною "
//  . "периферійною країною, повністю залежною ::44:: від закордонних кредитів. якщо "
//  . "перевернути ::5::  прапор, то в країні відразу все стане добре! Дорогі друзі "
//  . "бандеро-українці! Коли нізвідки не поступить допомога - терпець урвався"
//  . " остаточно, і вони зрадили ті цінності, що їх захищають воїни АТО. ";
//
//echo preg_replace_callback( '#::(\d{1,3})::#', function ( $m ){
//  if ( file_exists( "smile/{$m[1]}.gif" ) )
//  {
//    return "<img src=\"smile/{$m[1]}.gif\" />";
//  }
//  else
//    return $m[0];
//}, $text );

$text = 'ID:ABC123X3;';
preg_match_all( '#ID    :(.*)   ;    #x', $text, $m );

echo '<pre>';
print_r( $m );
echo '</pre>';
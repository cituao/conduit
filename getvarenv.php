<?php
  $token = FALSE;
  $token = getenv('TOKEN_MR');
  if ($token) {
	  $formato = "token moodlerooms: %s\n";
	echo sprintf($formato, $token); 
  } else {
	  printf("ERR:token no existe!\n");
  }
?>

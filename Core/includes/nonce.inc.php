<?php

require_once 'Nonce.php';

$nonce = New Nonce ( );

$cnonce = $nonce->get_nonce( );
$hash = hash('sha512', $cnonce);

if(isset($_POST["submit"])) {

If($nonce->verify_nonce (cnonce, $hash)){

} else {
Print 'Invalid Form Submission';

}

}

?>

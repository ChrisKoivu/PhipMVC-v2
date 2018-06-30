<?php

Class Nonce {
Private $nonce_id = NULL;
Private $server_nonce = NULL;

Public function __construct( ){
 
}

Private function store_nonce ($nonce_id, $nonce) {
  $server_nonce = array (
    'nonce_id'=> $nonce_id,
    'nonce'=> $nonce 
  );
  $session = New Session();
  set_session_value($nonce_id, $server_nonce);
}

Public function get_nonce ( ) {
$token = New Token( );
$this->nonce_id = $token->generate_token (16);
$nonce = hash('sha512', $token->generate_token (256));
$this->store_nonce ($this->nonce_id, $nonce);
return $nonce;
}

Public function get_stored_nonce ($nonce_id){
   $session = New Session();
   return $session->get_session_value($nonce_id);
}

Public function verify_nonce($cnonce, $hash) {
$nonce = $this->get_stored_nonce($this->nonce_id); // Fetch the nonce from the last request
if (!empty($nonce)) {
remove_nonce($this->nonce_id);
$testHash = hash('sha512', $nonce . $cnonce);
return $testHash == $hash;
} else {
return false;
}
}

Public function remove_nonce ($nonce_id){
$this->server_nonce[$nonce_id]['nonce_id'] = NULL;
}





}
?>
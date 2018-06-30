<?php

Class Nonce {
    Private $nonce_id = NULL;

    Public function __construct( ){
    
    } // end of constructor

    // save generated nonce to the session
    Private function store_nonce ($nonce_id, $nonce) {
        $server_nonce = array (
            'nonce_id'=> $nonce_id,
            'nonce'=> $nonce 
        );
        $session = New Session();
        set_session_value($nonce_id, $server_nonce);
    } // end of store nonce
 
    // generate a new nonce for the form
    Public function get_nonce ( ) {
        $token = New Token( );
        $this->nonce_id = $token->generate_token (16);
        $nonce = hash('sha512', $token->generate_token (256));
        $this->store_nonce ($this->nonce_id, $nonce);
        return $nonce;
    } // end of get nonce function

    // retrieve the saved nonce from the session
    Public function get_stored_nonce ($nonce_id){
        $session = New Session();
        return $session->get_session_value($nonce_id);
    }

    // verify form nonce is valid
    Public function verify_nonce($cnonce, $hash) {
      $nonce = $this->get_stored_nonce($this->nonce_id); // Fetch the nonce from the last request
      // verify the stored nonce exists
      if (!empty($nonce)) {
         remove_nonce($this->nonce_id); 
         $testHash = hash('sha512', $nonce . $cnonce);
         // returns the result of the hash comparison
         return ($testHash === $hash);
      } else {
         // there is no nonce, so return false
         return false;
      }
    } // end of verify nonce function

    // remove the stored nonce from the session
    Public function remove_nonce ($nonce_id){
        $session = New Session();
        set_session_value($nonce_id, NULL);
    } // end of remove nonce function

} // end of nonce class
?>
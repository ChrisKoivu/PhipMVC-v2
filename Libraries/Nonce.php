<?php

Class Nonce {
    Private $nonce_id = NULL;

    Public function __construct( ){
    
    } // end of constructor

    // save generated nonce to the session
    Private function store_nonce ($nonce_id, $nonce) {
        $session = New Session();
        $session->set_session_value($nonce_id, $nonce);
    } // end of store nonce
 
    // generate a new nonce for the form
    Public function get_nonce ( ) {
        $token = New Token( );
        $this->nonce_id = $token->generate_token (16);
        $nonce = $token->generate_token (256);
        $nonce = hash('sha512', $nonce);
        // save nonce to session
        $this->store_nonce ($this->nonce_id, $nonce);
        return $nonce;
    } // end of get nonce function

    // retrieve the saved nonce from the session
    Public function get_stored_nonce ($nonce_id){
        $session = New Session();
        return $session->get_session_value($nonce_id);
    }

    // verify form nonce is valid
    Public function verify_nonce($cnonce) {
      // Fetch the nonce from the last request
      $nonce = $this->get_stored_nonce($this->nonce_id);     
      // verify the stored nonce exists
      if (!empty($nonce)) {
        $this->remove_nonce($this->nonce_id); 
        // return comparison results
        return ($cnonce === $nonce);
      } else {
         // there is no nonce, so return false
         return false;
      }
    } // end of verify nonce function

    // remove the stored nonce from the session
    Public function remove_nonce ($nonce_id){
        $session = New Session();
        $session->set_session_value($nonce_id, NULL);
    } // end of remove nonce function

} // end of nonce class
?>
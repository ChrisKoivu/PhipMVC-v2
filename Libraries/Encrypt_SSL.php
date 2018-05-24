// Generate a public and private key
function generate()
{
    // Set the key parameters
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Create the private and public key
    $res = <a href="http://www.php.net/manual/en/function.openssl-pkey-new.php">openssl_pkey_new</a>($config);

    // Extract the private key from $res to $privKey
    <a href="http://www.php.net/manual/en/function.openssl-pkey-export.php">openssl_pkey_export</a>($res, $privKey);

    // Extract the public key from $res to $pubKey
    $pubKey = <a href="http://www.php.net/manual/en/function.openssl-pkey-get-details.php">openssl_pkey_get_details</a>($res);

    return array(
        'private' => $privKey,
        'public' => $pubKey["key"],
        'type' => $config,
    );
}

// Encrypt data using the public key
function encrypt($data, $publicKey)
{
    // Encrypt the data using the public key
    <a href="http://www.php.net/manual/en/function.openssl-public-encrypt.php">openssl_public_encrypt</a>($data, $encryptedData, $publicKey);

    // Return encrypted data
    return $encryptedData;
}

// Decrypt data using the private key
function decrypt($data, $privateKey)
{
    // Decrypt the data using the private key
    <a href="http://www.php.net/manual/en/function.openssl-private-decrypt.php">openssl_private_decrypt</a>($data, $decryptedData, $privateKey);

    // Return decrypted data
    return $decryptedData;
}

// Encrypt and then decrypt a string
$arrKeys = generate();
$strEncrypted = encrypt('Hello World!', $arrKeys['public']);
$strDecrypted = decrypt($strEncrypted, $arrKeys['private']);
echo $strDecrypted;



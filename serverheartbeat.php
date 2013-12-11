<?php
    require_once("connect.php");

    $public_address = $_SERVER['REMOTE_ADDR'];
    
    $db->refreshServer($public_address);
    $clients = $db->getClients($public_address);

    header('Content-type: text/xml');
?>
<?xml version="1.0" encoding="UTF-8"?>
<clients>
<?php foreach ($clients as $client) { ?>
    <client>
        <address><?php echo $client; ?></address>
    </client>
<?php } ?>
</clients>

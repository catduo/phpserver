<?php
    require_once("connect.php");

    $servers = $db->getActiveServers();

    header('Content-type: text/xml');
?>
<?xml version="1.0" encoding="UTF-8"?>
<servers>
<?php foreach ($servers as $server) { ?>
    <server>
        <address><?php echo $server; ?></address>
    </server>
<?php } ?>
</servers>

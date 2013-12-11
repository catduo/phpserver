connect.php
- Include this in every file, it creates the DB connection and instantiates the db object

secret.php
- Holds credentials

db.php
- This is where all of the database operations are.. this should be abstracted at some point

gamedata.php
- This is an endpoint that allows you to get and set properties for a game (save game information)

index.php
- Debugging only, will have various functionality

register.php
- Allows you to register a user with a password

login.php
- Makes a passowrd challenge, returns 200 if pass, 401 Unauthorized if failed

serverheartbeat.php
- This is called by the server every ~5s to annouce the game's presence on the network, it allows clients to see it
- returns XML for the users that are trying to connect to this server

serverlist.php
- Lists all the currently available servers in XML

joinserver.php
- Called by the client with the post value "privateAddress" set will place the client in to the list for 10 seconds. The client must continue to post to here while they are waiting to join (until the server connects with them)

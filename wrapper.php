<?php

class DiscordAPI
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function joinServer($inviteCode)
    {
        return ['result' => 'Joined server: ' . $inviteCode];
    }

    public function setCustomStatus($status)
    {
        return ['result' => 'Custom status set: ' . $status];
    }

    public function sendMessage($channelId, $content)
    {
        return ['result' => 'Message sent to channel ' . $channelId . ': ' . $content];
    }

    public function raid()
    {
        return ['result' => 'Raid executed'];
    }

    public function getFriends()
    {
        return ['result' => 'Retrieved friends list'];
    }

    public function deleteFriend($friendId)
    {
        return ['result' => 'Friend deleted: ' . $friendId];
    }

    public function getGuilds()
    {
        return ['result' => 'Retrieved guilds list'];
    }

    public function deleteGuild($guildId)
    {
        return ['result' => 'Guild deleted: ' . $guildId];
    }

    public function handleRequest($action, $params)
    {
        switch ($action) {
            case 'joinServer':
                $inviteCode = $params['inviteCode'];
                return $this->joinServer($inviteCode);

            case 'setCustomStatus':
                $status = $params['status'];
                return $this->setCustomStatus($status);

            case 'sendMessage':
                $channelId = $params['channelId'];
                $content = $params['content'];
                return $this->sendMessage($channelId, $content);

            case 'raid':
                return $this->raid();

            case 'getFriends':
                return $this->getFriends();

            case 'deleteFriend':
                $friendId = $params['friendId'];
                return $this->deleteFriend($friendId);

            case 'getGuilds':
                return $this->getGuilds();

            case 'deleteGuild':
                $guildId = $params['guildId'];
                return $this->deleteGuild($guildId);

            default:
                return ['error' => 'Invalid action'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $params = $_POST['params'];

    // Example usage:
    $token = 'YOUR_DISCORD_TOKEN';
    $api = new DiscordAPI($token);
    $response = $api->handleRequest($action, $params);

    header('Content-Type: application/json');
    echo json_encode($response);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Discord API Web Interface</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Discord API Web Interface</h1>
    <form id="apiForm" method="POST">
        <input type="hidden" name="action" id="action">
        <input type="hidden" name="params" id="params">
    </form>

    <button onclick="performAction('joinServer')">Join Server</button>
    <button onclick="performAction('setCustomStatus')">Set Custom Status</button>
    <button onclick="performAction('sendMessage')">Send Message</button>
    <button onclick="performAction('raid')">Raid</button>
    <button onclick="performAction('getFriends')">Get Friends</button>
    <button onclick="performAction('deleteFriend')">Delete Friend</button>
    <button onclick="performAction('getGuilds')">Get Guilds</button>
    <button onclick="performAction('deleteGuild')">Delete Guild</button>

    <script>
        function performAction(action) {
            var params = {};

            switch (action) {
                case 'joinServer':
                    params.inviteCode = prompt('Enter the invite code:');
                    break;

                case 'setCustomStatus':
                    params.status = prompt('Enter the custom status:');
                    break;

                case 'sendMessage':
                    params.channelId = prompt('Enter the channel ID:');
                    params.content = prompt('Enter the message content:');
                    break;

                case 'deleteFriend':
                    params.friendId = prompt('Enter the friend ID:');
                    break;

                case 'deleteGuild':
                    params.guildId = prompt('Enter the guild ID:');
                    break;
            }

            $('#action').val(action);
            $('#params').val(JSON.stringify(params));
            $('#apiForm').submit();
        }
    </script>
</body>
</html>

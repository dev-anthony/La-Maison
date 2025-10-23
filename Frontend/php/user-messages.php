<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="/Authentication/Frontend/css/message.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0"/>
</head>
<body>
    <div class="container">
        <div class="header-container">
        <h3 id="chat-header"></h3>
        </div>
        <div class="chat-container">
        <div id="chat-box"></div>
        </div>

        <div class="chat-footer">
            <form id="chat-form" class="chat-form">
                    <textarea type="text" id="message" placeholder="Type your message..." class="message-input"> </textarea>
                    <div class="chat-controls">
                        <button id="file-cover"  class="material-symbols-rounded">attach_file</button>
                    <input type="file" id="file"  class="file"/>
                    <button type="submit" class="material-symbols-rounded">
					arrow_upward
					</button>
                    </div>
            </form>
        </div>
        
    </div>
    <script src="/Authentication/Frontend/js/chat.js">
       
    </script>
</body>
</html> -->
<?php
require_once '../../Config/config.php'; // correct relative path from Frontend/php/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="<?= $BASE_URL ?>/Frontend/css/message.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0"/>
</head>
<body>
    <div class="container">
        <div class="header-container">
            <h3 id="chat-header"></h3>
        </div>
        <div class="chat-container">
            <div id="chat-box"></div>
        </div>

        <div class="chat-footer">
            <form id="chat-form" class="chat-form">
                <textarea type="text" id="message" placeholder="Type your message..." class="message-input"></textarea>
                <div class="chat-controls">
                    <button id="file-cover" class="material-symbols-rounded">attach_file</button>
                    <input type="file" id="file" class="file"/>
                    <button type="submit" class="material-symbols-rounded">arrow_upward</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= $BASE_URL ?>/Frontend/js/chat.js"></script>
</body>
</html>

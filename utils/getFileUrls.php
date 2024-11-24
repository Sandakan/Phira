<?php
function getFileUrl($file_type, $filename)
{
    $FILE_TYPES = array("PRIVATE_USER_PHOTO", "CHAT_MEDIA");
    if (!in_array($file_type, $FILE_TYPES)) {
        switch ($file_type) {
            case "PRIVATE_USER_PHOTO":
                return BASE_URL . "/private/media/user_photos/" . $filename;
            case "CHAT_MEDIA":
                return BASE_URL . "/private/media/chats/" . $filename;
        }
    }
    throw new Exception("Invalid file type");
}

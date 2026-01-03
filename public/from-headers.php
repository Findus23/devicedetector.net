<?php

$mode = (empty($_GET["mode"])) ? "set-header" : $_GET["mode"];


if ($mode == "read-header") {
    $userAgent = empty($_SERVER["HTTP_USER_AGENT"]) ? "" : $_SERVER["HTTP_USER_AGENT"];
    $text = "";
    foreach ($_SERVER as $var => $value) {
        if (str_contains($var, "HTTP_SEC_CH")) {
            $header = str_replace("HTTP_", "", $var);
            $header = str_replace("_", "-", $header);
            $text .= "$header: $value\n";
        }
    }
    $url = "/" . rawurlencode($userAgent);
    if (!empty($text)) {
        $url .= "||" . rawurlencode($text);
    }
    header('Location: ' . $url, true, 302);
} else {
    header('Accept-CH: Sec-CH-UA-Full-Version, Sec-CH-UA-Platform, Sec-CH-UA-Platform-Version, Sec-CH-UA-Model, Sec-CH-UA-Arch', true);
    header('Location: ?mode=read-header', true, 302);
}



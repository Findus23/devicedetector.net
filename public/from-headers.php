<?php

$mode = (empty($_GET["mode"])) ? "set-header" : $_GET["mode"];

$allHeaders = [
//    from https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers
    "Sec-CH-UA",
    "Sec-CH-UA-Arch",
    "Sec-CH-UA-Bitness",
    "Sec-CH-UA-Form-Factors",
    "Sec-CH-UA-Full-Version",
    "Sec-CH-UA-Full-Version-List",
    "Sec-CH-UA-Mobile",
    "Sec-CH-UA-Platform-Version",
    "Sec-CH-UA-WoW64",
    "Sec-CH-Prefers-Color-Scheme",
    "Sec-CH-Prefers-Reduced-Motion",
    "Sec-CH-Prefers-Reduced-Transparency",
    "Sec-CH-Device-Memory",
    "Sec-CH-DPR",
    "Sec-CH-Viewport-Width",
    "Sec-CH-Width"
];

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
    header('Accept-CH: ' . implode(", ", $allHeaders), true);
    header('Location: ?mode=read-header', true, 302);
}



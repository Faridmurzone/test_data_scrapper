<?php 

$link = 'https://www.garbarino.com/productos/tv-led-y-smart-tv/4k-ultra-hd/4342aaai';

function get_http_response_code($link) {
        $headers = get_headers($link);
        $validURL = substr($headers[0], 9, 3);
        return $validURL;
}

$validURL = get_http_response_code($link);

if($validURL == 200) {
echo $link;
}

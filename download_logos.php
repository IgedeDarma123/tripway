<?php
$urls = [
    'tiket' => 'https://s-light.tiket.photos/t/01E25EBZS3W0FY9PEDRVVLWEFR/original/logo/2021/07/22/026d3ca0-cecb-4b71-b016-8c46f1ec5f79-1626960161494-0cfbdf0f0322197f26d6a2f8c05763f3.png',
    'traveloka' => 'https://ik.imagekit.io/tvlk/image/imageResource/2023/09/27/1695806679237-75059d07010260a927a7c7ce3ea88c75.png',
    'trip' => 'https://upload.wikimedia.org/wikipedia/commons/7/74/Trip.com_logo.svg',
    'expedia' => 'https://upload.wikimedia.org/wikipedia/commons/5/5f/Expedia_logo.svg',
    'klook' => 'https://upload.wikimedia.org/wikipedia/commons/c/c8/Klook_Logo.svg',
    'viator' => 'https://upload.wikimedia.org/wikipedia/commons/3/36/Viator_logo.svg',
    'airbnb' => 'https://upload.wikimedia.org/wikipedia/commons/6/69/Airbnb_Logo_B%C3%A9lo.svg',
    'booking' => 'https://upload.wikimedia.org/wikipedia/commons/b/b2/Booking.com_Logo.svg',
    'google' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
    'getyourguide' => 'https://upload.wikimedia.org/wikipedia/commons/6/65/GetYourGuide_logo.svg'
];

@mkdir('public/images/partners', 0777, true);

$options = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($options);

foreach ($urls as $name => $url) {
    echo "Downloading $name... ";
    $content = @file_get_contents($url, false, $context);
    if ($content) {
        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (!$ext) $ext = 'png';
        file_put_contents('public/images/partners/' . $name . '.' . $ext, $content);
        echo "OK ($ext)\n";
    } else {
        echo "FAILED\n";
    }
}

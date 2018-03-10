<?php

if (getenv('DATABASE_URL')) {
    $dbUrl = getenv('DATABASE_URL');
    $dbUrlParsed = parse_url($dbUrl);
    putenv('POSTGRES_ADDRESS=' . $dbUrlParsed['host']);
    putenv('POSTGRES_DB=' . substr($dbUrlParsed['path'], 1));
    putenv('POSTGRES_USER='.$dbUrlParsed['user']);
    putenv('POSTGRES_PASSWORD='.$dbUrlParsed['pass']);
}

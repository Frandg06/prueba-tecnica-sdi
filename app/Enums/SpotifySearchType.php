<?php

namespace App\Enums;

enum SpotifySearchType: string
{
    case album = 'album';
    case artist = 'artist';
    case playlist = 'playlist';
    case track = 'track';
    case show = 'show';
    case episode = 'episode';
    case audiobook = 'audiobook';
}

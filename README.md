# podyt

Create a podcast feed from youtube videos

# Configuration

## Youtube API

In order to retrieve the meta data about a youtube video, ```YOUTUBE_API_KEY``` has to be set in the .env file.

=> https://developers.google.com/youtube/v3/getting-started

## Youtube-dl

In order to download / convert the youtube videos to mp3, youtube-dl has to be installed and accessible at the path specified as ```YOUTUBE_DL_BINARY``` in the .env file

=> https://youtube-dl.org/

## FFMPEG

For converting the downloaded youtube video to mp3, ffmpeg is required, accessible, and path provided in ```FFMPEG_BINARY``` .env variable


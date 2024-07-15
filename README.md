# podyt

Create a podcast feed from youtube videos

# Configuration

## Youtube API

Set the api key in the .env file as ```YOUTUBE_API_KEY```

## OpenAI API

To use the openai api (for answer feeds), set the api key in the .env file as ```OPENAI_API_KEY```

## YTDLP

In order to download / convert the youtube videos to mp3, youtube-dl has to be installed and accessible at the path specified as ```YOUTUBE_DL_BINARY``` in the .env file

=> https://github.com/yt-dlp/yt-dlp

## FFMPEG

For converting the downloaded youtube video to mp3, ffmpeg is required, accessible, and path provided in ```FFMPEG_BINARY``` .env variable

=> https://ffmpeg.org/

## Queue and workers

Workers need to be configured following laravel's queue documentation to perform the conversion to mp3 and associated tasks.

**Required to be database or [laravel-workflow](https://github.com/laravel-workflow/laravel-workflow) compatible driver (not sync)**

# Credits

Background picture from unsplash : https://unsplash.com/photos/cVI8ViAhU04



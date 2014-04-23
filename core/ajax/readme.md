##Ajax##


### Request ###

Ajax calls are done within this sub directory.
You can call a file with the needed parameters in your javascript function.

    http://localhost:8888/zeejong/core/ajax/news.php?feed=0

The scripts will return JSON objects with the needed information


### Debug ###

If you need formatted JSON in your browser, you must call the file with the `debug` parameter.

    http://localhost:8888/zeejong/core/ajax/news.php?feed=0&debug
    
This will you give you a cleaner output
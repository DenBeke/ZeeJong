ZeeJong - Soccer Betting System
===============================

About
-----

*ZeeJong* is an online betting system for football matches.  
The web app is designed to collect and display all relevant information about any match in the world of soccer
and lets users place bets on upcoming events.

Unregistered visitors have access to a large archive of competitions, seasons, matches, players, coaches and referees.  
On the match page, an overview of the match is given. Visitors can see the date, final score, referees and players. Both goals and cards are also shown on the match page.  
Players, referees, coaches and teams are displayed with their information. Visitors can also view graphs containing the stats of them.

Registered users have the ability to place bets on upcoming events. Those bets can be done individually, but can also be done in groups.  
Users who created groups can invite other users in them, bet against each other, and use the online chatbox on the group page.


Installation
------------

###Requirements###

- PHP 5.5 or newer
- PDO for mysqli
- Apache mod_rewrite support
- (Depending on the size of the import data, your server may need a lot of RAM)

###Uploading###
In order to have a website your must upload the *zeejong* folder to your webserver. **But more important are the file/folder permissions on your server!**

* First of all, your webserver must have the permission to access the files.
* In order to store the chatbox content, Apache must have write access to the `core/php-chatbox/` directory
* When running the parser, the user running the parser must have write (and of course also read) access to the `core/cache/` and `images/` directories.
* With an automatic installation, *ZeeJong* must have write access to the root folder, for creating the config file.
* To avoid people taking down your server with DDOS attacks, you shouldn't make your webserver able to run the `core/parser.php` and `core/mailer.php`.

###Installer###
In order to install *ZeeJong* you must navigate to the installation
directory with your browser.  
Navigate to `http://yourdomain.com/install/` and fill all fields. The script
will create the database tables and will generate a config file.

You can also install preloaded data. We provide a JSON file containing an archive of competitions.  
The preloaded data is provided in a JSON file, but you can also retrieve the archive yourself, by running the *ZeeJong Parser* tool.

> ZeeJong Parser is a tool, written in GO, which collects and builds a database containing an archive of soccer information.

In order to install this, you must run `http://yourdomain.com/core/importer.php`. This may take some time.  
*Do this after the installation. You need empty tables in your database.*


###Maintenance###
To find and update new matches, you have to run the parser, located at `/core/parser.php`. This script isn't meant for running in the browser, but immediately through the command line (or even better, with a cronjob).
Doing this with a cron job every night ensures that your data stays up to date and that bets are processed fully automatically on a daily basis.

Another script that needs to be runned, is the `core/mailer.php` script.  This will keep users informed about upcoming events.


Authors
-------

- Mathias Beke
- Timo Truyts
- Alexander Vanhulle
- Bruno Van de Velde
- Elias Van Langenhove


Acknowledgements
----------------

- URL routing: [GluePHP](http://gluephp.com)
- RSS parser: [SimplePie RSS](http://simplepie.org)
- Wikipedia information: [Wikipedia](http://wikipedia.org) & [wikidrain](https://github.com/abreksa4/wikidrain)
- Design framework: [Bootstrap](http://getbootstrap.com)
- Graphs: [Highcharts](http://www.highcharts.com)
- OpenID login: [LightOpenID](https://code.google.com/p/lightopenid/)
- Chat: [PHP-Chatbox](https://github.com/MarcinMM/PHP-Chatbox)
- Country flags: [Free Country Flags by Gang of the Coconuts](http://www.free-country-flags.com)
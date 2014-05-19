ZeeJong - Soccer Betting System
===============================

*ZeeJong* is an online betting system for soccer matches.
Matches, teams and players are automatically added to the database.

About
-----



Installation
------------

*Requirements*

- PHP 5.5 or newer
- PDO for mysqli
- Apache mod_rewrite support

In order to install *ZeeJong* you must navigate to the installation
directory with your browser.  
Navigate to `yourdomain.com/install` and fill all fields. The script
will create the database tables and will generate a config file.

You can also install preloaded data. We provide a JSON file contain an archive of competitions.  
In order to install this, you must run `yourdomain.com/core/importer.php`. This may take some time.  
*Do this after the installation. Note that the script will empty all tables before loading the sample data.*


Authors
-------

- Mathias Beke
- Timo Truyts
- Alexander Vanhulle
- Elias Van Langenhove
- Bruno Van de Velde


Acknowledgments
---------------

- URL routing: [GluePHP](http://gluephp.com)
- RSS parser: [SimplePie RSS](http://simplepie.org)
- Wikipedia information: [Wikipedia](http://wikipedia.org) & [wikidrain](https://github.com/abreksa4/wikidrain)
- Wikipedia info-box: [DBpedia](http://dbpedia.org/About)
- Design framework: [Bootstrap](http://getbootstrap.com)
- Graphs: [Highcharts](http://www.highcharts.com)
- OpenID login: [LightOpenID](https://code.google.com/p/lightopenid/)
- [PHP-Chatbox](https://github.com/MarcinMM/PHP-Chatbox)
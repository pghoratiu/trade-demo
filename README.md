About
=====
A simple trade message processor architecture developed using php>=5.4.

Setup
=====

1. Install composer
2. Install composer dependencies
3. Open up website, simplest way is via the embeded php web server

        cd public
        php -S localhost:8000

4. Create new entries in the database via:

        cli/random-json.php - is used to generate random json payload
        cli/curl.php - post output of random-json.php to http://localhost:8000//process/trade-message

5. Open website: [localhost:8000](http://localhost:8000/)

Deployment
=========

Site is available on [demo.prolix.ro](http://demo.prolix.ro:8000).
# Lego Sets scraper

## Description
 - Lego sets detail scraper from DK based online shop. Fetching raw html, using DOMXML & DOMXPath.
 - Please check the */doc folder* for further information

## Requirements
 - PHP 5x
 - DOMXML module
 - MySQL/MariaDB
 - Wordpress 4.x (4.4 preferably)
 - cUrl/libCurl

## Install
 - Copy into the wordpress /wp-content/plugins directory
 - Add the sql file to the database from /doc/legosets.sql directory
 - Enable the 'Lego set manager' plugin in WP admin plugins section

## Usage
 - Open the WP Admin
 - Check the menu 'Lego set manager' -> It should list all available (fetchable) site for scraping
 - Check the sub-menu 'Update sets' -> It should update/insert all fetched data and store it into database


### File structure
 - /doc folder ----------------------------- sql db file and other infos
 - index.php ------------------------------- default index file for plugin security
 - lego-scrape.php ------------------------- scraper logic file (lib)
 - lego-sracper.php ------------------------ the main plugin file (aka such a controller)
 - lego-scraper-model.php ------------------ the model file (all db handling)
 - smallCurl.php --------------------------- very small php cURL implementation library
 - readme.md ------------------------------- this file... :) 
// WEATHER.COM XML PARSER
// Version 1.4
// Copyright 2005 Nick Schaffner
// http://53x11.com

This PHP script will allow you to monitor your current local weather via a Weather.com XML feed.  It parses the XML data and then outputs formatted HTML to a .txt file.  This .txt file can then be integrated into your website via SSI, PHP or any other language that will accept Includes.  It is intended to be setup as a Cron Job, that is accessed to update only every few minutes.  If it were accessed more often, Weather.com would shut down your XML feed.

1. You need to acquire a Partner ID and License Key from Weather.com.  This service is completely free, and they only want your email.  Visit http://www.weather.com/services/xmloap.html to sign up.

2. Once you have your info from Weather.com, you will need to open weather.php with a text editor and configure the script.

Input the ZIPCODE you wish to track the current conditions for.  Enter your Partner ID and License Key.  Input the root path to the weather.txt file.  This path is critical because it will need to be accessed via PHP on your server with Cron Job.

Enter the path to the Weather icon folder.  This is the path your (SSI, PHP, etc) file with the Include will use for finding the icons.  For example, if you are accessing the weather information from your index.php file, and the weather folder was located in images/weather - then the path would be "images/weather".

If you would like the results of the script emailed to you each time it runs, set $email to TRUE and input your email address.

To use Metric units (Celsius and KMH), set $units to 'metric'.

3. If you have a knowledge of PHP and HTML, you can customize what will be output to the weather.txt file.  Edit this information in the area listed.

4. Upload weather.php and the weather folder to your website.

5. CHMOD weather.txt to 777

6. CHMOD weather.php to 755

7. Now you need to setup a Cron Job to access your server's php and then the weather.php.  The following Cron Job is a sample and will update your weather.txt file every 10 minutes.

*/10 * * * * /usr/local/bin/php public_html/weather.php

You will need to alter the PHP location and root location of your weather.php to match your server.

8. Now weather.txt file will be updated with the current conditions at the intervals you designated in your Cron Job. You just need to use an Include function to add the content in your webpage. For example:

<?php include("weather.txt"); ?>

Or

<!--#include file="weather.txt" -->




version History
---------------
1.4 	06/22/05	24h Clock option
1.3 	06/19/05	Metric unit support
1.1	04/25/05	Added email alert
1.0	04/16/05	XML Parser
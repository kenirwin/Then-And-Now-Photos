# Then-And-Now-Photos

## Description
This is a simple web app to pair an old photo with a new one of the same person to create a then-and-now side-by-side photo suitable for sharing on social media. The app was designed with the intent to offer it as an in-person, human-mediated service at university Homecoming events.

## System Requirements
* PHP 7+
  * with the ‘intl’ extension installed/enabled
  * with the ability to send/receive mail
* PHP Composer
* MySQL

## Installation (linux command-line)

### Repo
* Clone the repo
* `composer install` (or `php composer.phar install` -- see [GetComposer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos))

### Database
* Create database and a username & password with read/write/create permissions
* `cp config_sample.php config.php`
* Add database credentials to config.php

### Email
* Create an email address to receive incoming emails
* pipe emails to that address to: /ABSOLUTE/PATH/TO/REPO/mailtest.php

## The intended workflow: 
* university staff prepare for an event by scanning old photos of likely event attendees (we did this by scanning all yearbooks for 5, 10, 15, ... 40th reunion years and breaking them up into individual photos per person).
* staff create an image "frame" image using university colors, logos, etc.
* names and files are loaded up to a server on the back-end using FTP and MySQL - the app does not have functionality for this part of the workflow
* during an event, users take a selfie using a smartphone and 'email' the photo to an address configured to receive and process the file into the system
* the email triggers a script that adds the photo along with the sender's email address to a database file.
* a human intermediary (university staff) uses the application to select the old photo and the new. This generates a composite photo with the old & new images inside the frame created earlier, and adds the then/now dates and reunion year (e.g. "1980-2020, 40th Reunion")
* the app then sends the composite photo to the subject at the same email address from which they sent the photo. A copy is also saved in an archive section of the app. Ta-da!

### Why a human intermediary? 

Wouldn't it be easier to have users just upload an image and download the paired image themselves? Yes it would. It would also be easy to take your frenemy's old photo and pair it with a picture of Godzilla. We decided that keeping things under our control was a better plan. (If you want to fork the repo and do a more open version, go right ahead.) 

## License

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)
# spoicy.ch
spoicy.ch is my own personal playground for Laravel and Bootstrap experience.
## Pages
### [Main Page](https://spoicy.ch/)</h4>
The main page is home to links to all of my publicly available projects.
### [Socials Page](https://spoicy.ch/socials)
The socials page is home to links to my socials.
### [Social Media](https://spoicy.ch/media)
This page contains the five most recent posts/videos to various socials. Current it only displays Speedrun.com speedruns, YouTube videos and Twitter posts, and once finished will also include my GitHub feed. The goal of this page is to get used to implementing APIs from outside services.
### [JS-Framework](https://spoicy.ch/jsframework)
This page will contain the various projects I develop using the different JavaScript frameworks that are in use in the industry.
### [Blog](https://spoicy.ch/blog)
This page contains regular blog entries about the various projects I've been working on, combined with password secure admin tools to create and edit blog entries.
### [PowerWash Simulator Stats](https://spoicy.ch/powerwash)
This page contains various stats regarding the speedrun.com board for PowerWash Simulator. The goal is to provide neat statistics and external motivation for pushing times further.
## Other Functionality
### [Retrieve All Refunct Runs](https://github.com/Spoicy/spoicy.ch/blob/master/app/Console/Commands/RefunctRuns.php)
This is a command which retrieves all of the Refunct "Any% - Normal" runs from Speedrun.com and puts them all into a JSON file, consisting of the runner's username, profile picture and country, as well as the run's date and final time.
### [Password Hash Gen](https://github.com/Spoicy/spoicy.ch/blob/master/app/Console/Commands/PasswordHashGen.php)
This is a command that generates a password hash, which can be used to create passwords for internal tools.
## Setup
Clone this repository and install the dependencies:

    $ git clone https://github.com/Spoicy/spoicy.ch.git && cd spoicy.ch
    $ composer install
    $ npm install

Create a copy of the **.env.example** file and name it **.env**. Update the necessary configuration, especially the database connection details:

    $ cp .env.example .env

Run the necessary artisan commands:

    $ php artisan key:generate
    $ php artisan migrate

Compile assets and optionally serve:

    $ npm run dev
    $ php artisan serve
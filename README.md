# spoicy.ch
spoicy.ch is my own personal playground for Laravel and Bootstrap experience.
## Pages
### [Main Page](https://spoicy.ch/)</h4>
The main page is home to links to all of my publicly available projects.
### [Linktree](https://spoicy.ch/linktree)
The linktree page is home to links to my socials, much like the service [linktr.ee](https://linktr.ee/) provides.
### [Social Media](https://spoicy.ch/social) (WIP)
This page contains the five most recent posts/videos to various socials. Current it only displays Speedrun.com speedruns, YouTube videos and Twitter posts, and once finished will also include my GitHub feed. The goal of this page is to get used to implementing APIs from outside services.
### [JS-Framework](https://spoicy.ch/jsframework) (WIP)
This page will contain the various projects I develop using the different JavaScript frameworks that are in use in the industry.
### Double Alphabet (WIP, very barebones)
This page is a fun project within one of my friend groups where each day we come up with different two word combinations based on what two letters of the alphabet we're currently at (676 days in total).
## Other Functionality
### [Retrieve All Refunct Runs](https://github.com/Spoicy/spoicy.ch/blob/master/app/Console/Commands/RefunctRuns.php)
This is a command which retrieves all of the Refunct "Any% - Normal" runs from Speedrun.com and puts them all into a JSON file, consisting of the runner's username, profile picture and country, as well as the run's date and final time.
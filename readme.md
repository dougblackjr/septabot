# SEPTA BOT
[https://github.com/dougblackjr/septabot](https://github.com/dougblackjr/septabot)

## We'll build a thing that gets the next SEPTA train heading in a certain direction

This is going to be a very simple implementation of the SEPTA stats API to determine which train heading outbound is coming next.

We'll learn:
+ Very basic git and PHP stuff
+ Pseudocode
+ How to call an API and parse the data
+ How to Dump and Die!
+ How to never trust user input

This won't necessarily be best practices, but just enough to get your hands dirty in PHP. It'll be a very bare bones minimum viable product (just enough to get the job done).

You can see a bit of what we'll do in `index.php`!

### You'll Need
+ A computer
+ A notebook
+ A pen

### Getting Started
1. Download and install Git (Mac: `brew install git`)
2. Download and install Postman: [https://www.getpostman.com/docs/postman/launching_postman/installation_and_updates](https://www.getpostman.com/docs/postman/launching_postman/installation_and_updates)
3. Open your Terminal. We'll do some of our work here
4. "Clone the repo" (make a copy of the base code you'll need) by running in your terminal: `git clone https://github.com/dougblackjr/septabot.git`.
5. Type in terminal: `cd septabot/example`
6. Start a PHP server by typing in terminal: `php -S localhost`
7. Open Postman and do a New Request with the following parameters:
    + URL: `http://localhost/`
    + Request Type: POST (You'll see Get next to the URL bar)
    + Body:
        - token: 12345
        - command: train
        - text: Warminster (or Wil or snerd)
8. Play around! Enjoy!


### Git Resources
+ You'll need to install Git.
    + Mac: `brew install git`
    + First Run: [https://git-scm.com/book/en/v1/Getting-Started-First-Time-Git-Setup](https://git-scm.com/book/en/v1/Getting-Started-First-Time-Git-Setup)

### SEPTA API
[http://www.septastats.com/api](http://www.septastats.com/api)

### SLACK WEBHOOK
[https://api.slack.com/](https://api.slack.com/)
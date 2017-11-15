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

### SEE IT IN ACTION
```
cd septabot/example
php -S localhost
```

Then run a request with these parameters:
+ token: 12345
+ command: train
+ text: Warminster (or Wil or snerd)

### You'll Need
+ A computer
+ A notebook
+ A pen

### You'll Need Installed
+ Git: Mac: `brew install git`
+ Postman: [https://www.getpostman.com/docs/postman/launching_postman/installation_and_updates](https://www.getpostman.com/docs/postman/launching_postman/installation_and_updates)
    + For testing our bot

### Git Repo
+ You'll need to install Git.
    + Mac: `brew install git`
    + First Run: [https://git-scm.com/book/en/v1/Getting-Started-First-Time-Git-Setup](https://git-scm.com/book/en/v1/Getting-Started-First-Time-Git-Setup)
+ Clone the repo
    + [https://github.com/dougblackjr/septabot.git](https://github.com/dougblackjr/septabot.git)

### SEPTA API
[http://www.septastats.com/api](http://www.septastats.com/api)

### SLACK WEBHOOK
[https://api.slack.com/](https://api.slack.com/)
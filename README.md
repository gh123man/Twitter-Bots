Twitter-Bots
============

This is some (hacky/ugly/fast-written) php code that allows you to bot tiwtter accounts with a cron job. 

The workflow is as follows.


 - Pull data from a source (google news, youtube, reddit, anything with json api)
 - compress url
 - comress the title subtracting enough space for the url if needed
 - hashtag a *random* noun in the sentance
 - send tweet


This repo also includes a request token script I wrote. It is the only php command-line token *generator* that I know of. 

Keep in mind I wrote this in one weekend. One of the accounts using this method gained over 100 followers in 2 months wihtout me typing a single tweet myself.
-enjoy!

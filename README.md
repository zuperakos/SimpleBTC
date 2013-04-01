SimpleBTC
=========

SimpleBTC is a PHP frontend for a pushpool or PoolServerJ-based bitcoin mining
pool. It is a fork of the Simplecoin frontend, which at start of project had
been out of development for about a year. Currently the changes consist only
of bugfixes and minor updates, but the long-term goal is a complete overhaul
that will make SimpleBTC a modern web-application with database abstraction,
templating, internationalization, etc.

Features
--------

* User and worker management
* User and pool statistics
* Payout calculation and payments
* Basically everything you need to start a mining pool

Install
-------

You will first need the following prerequites:

* bitcoind and pushpool installed and configured
* PHP, tested under 5.2 but will likely work for many versions
* MySQL (more RDBMS to be supported in the future)
* Memcached
* PHP MySQL bindings

Note that SimpleBTC will provide a database schema for pushpool, so don't
worry about setting up a database for it yet.

Then, see INSTALL.md for install instructions.

Contribute
----------

SimpleBTC source and issue tracking are at online at
https://github.com/jcrawfordor/SimpleBTC. Please report problems, request
features, etc via the issue tracker there. Feel free to write some code
yourself!

Credits
-------

SimpleBTC is developed and maintained by Jesse B. Crawford,
http://jbcrawford.us. Donations are appreciated and can be directed to
17tTDgcgXBTN8u9VeBFQZ2KV5pDHCKvXjr. Perhaps consider donating some cycles
to his small pool at http://bitcoin.nmtbaycon.org/.

SimpleBTC is based on the now defunct SimpleCoin project, developed by Mike
Allison (dj.mikeallison@gmail.com, 163Pv9cUDJTNUbadV4HMRQSSj3ipwLURRc),
Wayno (1Gzcbs8dDYzf16qFWKHc5kWKuH8nji3pVt), and Tom Lightspeed
(tomlightspeed@gmail.com, 16p56JHwLna29dFhTRcTAurj4Zc2eScxTD). Patches to
SimpleCoin by William Waisse are additionally included in SimpleBTC.

SimpleCoin was in turn based on Miner Pool by Xenland
(12QY5HYbiT5Nx6fek8ss5pAywPsV3kqdu3).

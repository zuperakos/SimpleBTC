Installation:

1. Extract files into web root directory.
2. Create a database and user with full access.
3. Run simplebtc.sql in the database you created (This schema is for SimpleBTC and pushpool).
4. Copy includes/config.php.example to config.php and edit according to comments.
6. Setup cronjobs on a staggered schedule. For example,
```
0,30  *    *   *   *     php /var/www-bitcoin/cronjobs/archive.php
0     3    *   *   *     php /var/www-bitcoin/cronjobs/backupwallet.php
10,40 *    *   *   *     php /var/www-bitcoin/cronjobs/hashrate.php
15,45 *    *   *   *     php /var/www-bitcoin/cronjobs/shares.php
0     */6  *   *   *     php /var/www-bitcoin/cronjobs/payout.php
*/10  *    *   *   *     php /var/www-bitcoin/cronjobs/cronjob.php
*/10  *    *   *   *     cat /proc/loadavg > /var/www-bitcoin/loadavg.html
```
7. Register a user through the web interface, and manually set the 'admin' field for that user in WebUsers to 1.
8. Log in to the web interface, visit the admin panel, and configure appropriately.

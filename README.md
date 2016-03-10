# Docker container for ZendTo

Docker container for [ZendTo](http://zend.to), v. `4.12-5`.

Still very, very rough... but it will spin up and run. A few edits to get it to run in a more modern PHP environment.

Don't forget you need to manually set up the database and add an admin user. Think `docker exec -ti [container] bash` to get a cli.

There is a "fixed" MySQL import file in the `conf/` directory.

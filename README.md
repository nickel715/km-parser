# KM Parser

This tool parses log files and store them into a database.

## Usage

Just pipe the logfile in STDIN. For example like this:

`tail -n0 -f /var/log/apache/access.log | bin/console parse` 

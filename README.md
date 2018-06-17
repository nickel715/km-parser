# KM Parser

This tool parses log files and store them into a database.

## Install

```bash
git clone https://github.com/nickel715/km-parser.git
cd km-parser
composer install
```

change DATABASE_URL in `.env` and setup database with:

```bash
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```

## Usage

Just pipe the logfile in STDIN. For example like this:

`tail -n0 -f /var/log/apache/access.log | bin/console parse` 

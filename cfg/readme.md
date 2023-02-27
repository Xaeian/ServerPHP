## Config file `server.ini`:

It contains access data to databases as well as server and application settings.
The information contained in this file can be used by scripts placed in the `~scr/` directory and backend applications `~app/`.

An example configuration file:

```ini
cors = bypass

[auth]
enable = false
storage = csv

[debug]
enable = true
lineLimit = 100000
url = true
request = true
files = true
clear = true
response = true

[mysql]
host = localhost
user = root
password = ""

[influx]
token = "influxdb-token-code"

[{app}]
...
```

- `cors` - cross-origin policy support `null`|`bypass`|`whitelist`
- `auth` - authorization section
  - `enable` - whether authorization is enabled?
  - `storage` - data storage method `csv`|`mysql`|`sqlite`
- `debug` - API debug section
- `mysql` - data for **MySQL** database
  - `host` - IP address or URL of the database
  - `user` - user with full rights (administrator)
  - `password` - the password of the `user`
- `influx` - data for the **InfluxDB** database
  - `token` - administrator's token
- `{app}` - configuration variables for individual applications

## `conf.php` script:

Script load from the `conf.ini` file configuration paths to `httpd.conf`, `php.ini`, `my.ini` for different distributions:

- windows with `xampp`
- `windows` server
- `linux`

Running the `conf.php` script will replace the system configurations with the configurations prepared in this folder. It requires preparing appropriate files and placing them in the `~/cfg/conf/{dist}/` folder.

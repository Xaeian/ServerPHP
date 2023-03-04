# File service

The `app/file` service gives access to the directories inside _(excluding the `#` directory)_. Thus, we access the `/var/www/app/file/{path}` files via the `HTTP(S)` protocol:

```bash
GET {{host}}/file/{path} HTTP/1.1
```

## Redirect

Placing all files in this directory would be quite a limitation, especially for large datasets. Therefore, all paths to external directories _(from outside the `app/file` service)_ will be under the key pointing to them:

```ini
key1 = "/var/root/extdir/"
key2 = "D:/ExternalDirectory/"
```
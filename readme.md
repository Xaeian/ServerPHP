## Structure

- `api/` - routing folder for backend applications/services located in the `app` folder
- `app/` - backend applications/services
- `cfg/` - configuration files
- `lib/` - **php**, **js** and **py** libraries
- `scr/` - run scripts and daemons
- `web/` - frontend applications

**Logs** related to server queries are saved in `api/api.log`

## VSCode

For more convenient work with logs can be adjusted **visual studio code** settings

```json
{
  "logFileHighlighter.customPatterns": [
    { "pattern": "http://", "foreground": "#777" },
    { "pattern": "https://", "foreground": "#777" },
    { "pattern": "file://", "foreground": "#777" },
    { "pattern": "GET", "foreground": "#c486ba" },
    { "pattern": "POST", "foreground": "#c486ba" },
    { "pattern": "PUT", "foreground": "#c486ba" },
    { "pattern": "PATCH", "foreground": "#c486ba" },
    { "pattern": "DELETE", "foreground": "#c486ba" },
    { "pattern": "CONNECT", "foreground": "#c486ba" },
    { "pattern": "OPTIONS", "foreground": "#c486ba" },
    { "pattern": "TRACE", "foreground": "#c486ba" }
  ],
  "editor.tokenColorCustomizations": {
    "textMateRules": [
      { "scope": "log.error", "settings": { "foreground": "#d15148", "fontStyle": "" }},
      { "scope": "log.warning", "settings": { "foreground": "#dd9528", "fontStyle": "" }},
      { "scope": "log.info", "settings": { "foreground": "#579cd4", "fontStyle": "" }},
      { "scope": "log.debug", "settings": { "foreground": "#67ca7c", "fontStyle": "" }},
      { "scope": "log.constant", "settings": { "foreground": "#b5cda8", "fontStyle": "" }},
      { "scope": "log.date", "settings": { "foreground": "#4eb6a4", "fontStyle": "" }}
    ]
  }
}
```

In the `php.validate.executablePath` field there should be a path to the php interpreter, but if we specify a different path, **VSCode** will search all folders and index php files that we do not see in the project.

```json
{
  "php.validate.executablePath": "C:/Apache/",
  "intelephense.environment.includePaths": ["C:/Apache/"],
  "intelephense.environment.phpVersion": "8.1.6"
}
```

```json
{
  "editor.tabSize": 2,
  "editor.mouseWheelZoom": true,
  "editor.suggestSelection": "first",
  "editor.wordWrapColumn": 128,
  "explorer.sortOrder": "type",
}
```

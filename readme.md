### Structure

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
    { "pattern": "URL", "foreground": "#777" },
    { "pattern": "CLR", "foreground": "#777" },
    { "pattern": "FILE", "foreground": "#777" },
    { "pattern": "REQ", "foreground": "#777" },
    { "pattern": "RES", "foreground": "#777" }
  ],
  "editor.tokenColorCustomizations": {
    "textMateRules": [
      { "scope": "log.error", "settings": { "foreground": "#f16359", "fontStyle": "" } },
      { "scope": "log.warning","settings": { "foreground": "#faa82c", "fontStyle": "" } },
      { "scope": "log.info", "settings": { "foreground": "#59a2d9","fontStyle": "" } },
      { "scope": "log.debug", "settings": { "foreground": "#2fb885", "fontStyle": "" } },
      { "scope": "log.constant", "settings": { "foreground": "#c849cc", "fontStyle": "" } },
      { "scope": "log.date", "settings": { "foreground": "#46c4af", "fontStyle": "" } },
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

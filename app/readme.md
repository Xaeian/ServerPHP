





# Prepare & Build System

`dev.csv`
`dev` directory

Wszystkie funkcjonalności 

## Build application

Zbudować `Build` lub przebudować `Reuild`.

Funkcja `Build` usnie wszystkie zebrane dane, więc należy jej urzywać podczas tworzenia nowego systemu, kiedy celowo chcemy pozbyć się danych testowych lub zebrane dane są nie istotne.

W przypadku działającego systemu, aby nie utracić danych lepiej wykożystać funkcję `Reuild`, która nie usunie 

// Lepiej ją wykonywać gdy inne procesy nie dziłają


```php
$scada = new Scada();
$scada->Build();
$scada->Rebuild();
```

```r
PUT {{host}}/scada/build/ HTTP/1.1
PUT {{host}}/scada/rebuild/ HTTP/1.1
```




## API Applications

...

# Auth

Authorization service...

# File

File service...
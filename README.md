# PHPValidationClass
Extented PHP data/post validation class

## Form Data Validation

```PHP
pubic function func()
{
    $dummyData = [
        'title' => 'egoist',
        'type' => 'game',
    ];

    $this->data = $dummyData;

    $this->validate->data = $this->data;

    $this->validate->notRequire('x')->isNull()->typeIs('int')->length(3, 100)->check();
    $this->validate->require('title')->isNull()->typeIs('int')->length(3, 100)->check();
    $this->validate->require('type')->isNull()->typeIs('int')->valueIn([
        'operating_system', 
        'application', 
        'game', 
        'vr_app', 
        'vr_game', 
        'ar_app', 
        'ar_game', 
        'other'
    ])->check();

    $isValid = $this->validate->isSuccess();

    if (!$isValid){
        $this->printError($this->validate->errors);
    }
    // ...
}
```

## Other Validations

### usage
```PHP
echo $this->validate->isRgbColor('33,33,33,66') ? 'ok' : 'no';
```

### List of Validate Functions

* isEmail
* isId
* isUsername
* isPassword
* isUrl
* isJsonObject
* isJson
* isHexColor
* isRgbColor
* isRgbaColor
* findUserCredentialType
* isDateDmy
* isDateYmd
* isNull
* typeIs
* length
* valueIn
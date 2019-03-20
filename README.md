# PHPValidationClass
Extented PHP data/post validation class

## Form Data Validation

```PHP
pubic function func()
{
    $dummyData = [
        'title' => 'egoist',
        'type' => 'app',
    ];
    $this->data = $dummyData;

    $checkArgs = $this->validate->validateContents($this->data, [
        [
            'title',  // field name
            true,     // null check
            'string', // type check
            [3, 150], // length check
            false,    // enum check
        ],
        [
            'type',
            true,
            'string',
            [3, 20],
            ['operating_system', 'application', 'game', 'vr_app', 'vr_game', 'ar_app', 'ar_game', 'other'],
        ],
    ]);
    
    if ($checkArgs !== true) {
        return $this->result = $checkArgs;
    }
    // ...
}
```

## Other Validations

### usage
```PHP
echo $this->validate->isRgbColor('33,33,33,66') ? 'ok' : 'no';
```

### List

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
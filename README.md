Yii2-LongLog
===================
Yii2 extension for LongLog application<br>

Installation
---
```code
composer require "longlog/yii2-ext" "~1.0"
```

# Configurations
---
Edit `/common/config/main.php`:
```php
<?php
return [
    'components' => [
        'longlog' => [
            'class' => '\longlog\yii2\Component',
            'endpointUrl' => 'http://api.longlog.ru',
            'projectToken' => 'p8eGzXz5o4A2eulYhBvbrkghbAfirRwL',
        ],
    ],
];
```

# Usage
---
<b>Variant 1:</b> <i>LongLog with client wrapper</i>
```php
<?php
// New LongLog instance with client wrapper
$longLog = Yii::$app->longlog->newLog('CRON_SEND_EMAILS');
// Optionaly set payload any string 
$longLog->setPayload("userIds: [1,2,3]");
// Remember the processing start time
$longLog->start(); 

// ...YOUR JOB HERE...

// Submit LongLog to API
$longLog->finish()->submit();
```
<b>Variant 2:</b> <i>LongLog without client wrapper</i>
```php
<?php
// New LongLog instance without client wrapper
$longLog = new \longlog\LongLog('CRON_SEND_EMAILS');
// Optionaly set payload any string
$longLog->setPayload("userIds: [1,2,3]");
// Remember the processing start time
$longLog->start();

// ...YOUR JOB HERE...

// Calculate job processing time and submit log to API
$longLog->finish();

Yii::$app->longlog->getClient()->submit($longLog);
```

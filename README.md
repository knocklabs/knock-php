# Knock PHP library

## Documentation

See the [documentation](https://docs.knock.app) for PHP usage examples.

## Installation

```bash
composer require knocklabs/php-sdk
```

## Configuration

To use the library you must provide a secret API key, provided in the Knock dashboard.

```php
use Knock\KnockSdk\Client;

$client = new Client('sk_12345');
```

## Usage

### Identifying users

```php
$client->users()->identify('dinosaurs-loose', [
    'name' => 'John Hammond',
    'email' => 'jhammond@ingen.net',
]);
```

### Sending notifies (triggering workflows)

```php
$client->notify('jhammond', [
    // user id of who performed the action
    'actor' => 'dnedry',
    // list of user ids for who should receive the notification
    'recipients' => ['jhammond', 'agrant', 'imalcolm', 'esattler'],
    // data payload to send through
    'data' => [
        'type' => 'trex',
        'priority' => 1,
    ],
    // an optional identifier for the tenant that the notifications belong to
    'tenant' => 'jurassic-park',
    // an optional key to provide to cancel a notify
    'cancellation_key' => '21e958bb-2517-40bb-aaaa-d40acc26dac3',
]);
```

### Retrieving users

```php
$client->users()->get('jhammond');
```

### Deleting users

```php
$client->users()->delete('jhammond');
```

### Preferences

```php
$client->users()->setPreferences('jhammond', [
    'channel_types' => [
        'email' => true, 
        'sms' => false,
    ],
    'workflows' => [
        'dinosaurs-loose' => [
            'email' => false, 
            'in_app_feed': true,
        ]
    ]
]);
```

### Getting and setting channel data

```php
$knock->users()->setChannelData('jhammond', '5a88728a-3ecb-400d-ba6f-9c0956ab252f', [
    'tokens' => [
        $apnsToken
    ],
});

$knock->users()->getChannelData('jhammond', '5a88728a-3ecb-400d-ba6f-9c0956ab252f');
```

### Canceling workflows

```php
$client->workflows()->cancel('dinosaurs-loose', [
    'cancellation_key' => '21e958bb-2517-40bb-aaaa-d40acc26dac3'
    // optionally you can specify recipients here
    'recipients' => ['jhammond'],
]);
```

### Signing JWTs

You can use the `firebase/php-jwt` package to [sign JWTs easily](https://github.com/firebase/php-jwt).
You will need to generate an environment specific signing key, which you can find in the Knock dashboard.

If you're using a signing token you will need to pass this to your client to perform authentication.
You can read more
about [client-side authentication here](https://docs.knock.app/client-integration/authenticating-users).

```php
use Firebase\JWT\JWT;

$privateKey = env('KNOCK_SIGNING_KEY');
$encoded = JWT::encode(['sub' => 'jhammond'], $privateKey, 'RS256');
```

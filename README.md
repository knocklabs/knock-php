# Knock PHP library

## Documentation

See the [documentation](https://docs.knock.app) for PHP usage examples.

## Installation

```bash
composer require knocklabs/knock-php php-http/guzzle7-adapter
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
$client->users()->identify('jhammond', [
    'name' => 'John Hammond',
    'email' => 'jhammond@ingen.net',
]);
```

### Sending notifies (triggering workflows)

```php
$client->workflows()->trigger('dinosaurs-loose', [
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
            'in_app_feed' => true,
        ]
    ]
]);
```

### Preference center

```php
$client->users()->getPreferenceCenterConfig('jhammond');

$client->users()->generatePreferenceCenterSignedUrl('jhammond');
```

### Getting and setting channel data

```php
$client->users()->setChannelData('jhammond', '5a88728a-3ecb-400d-ba6f-9c0956ab252f', [
    'tokens' => [
        $apnsToken
    ],
]);

$client->users()->getChannelData('jhammond', '5a88728a-3ecb-400d-ba6f-9c0956ab252f');
```

### Tenants

```php
$client->tenants()->set('jurassic-park', [
    'name' => 'Jurassic Park',
]);

$client->tenants()->bulkSet([
    ['id' => 'isla-nublar', 'name' => 'Isla Nublar'],
    ['id' => 'isla-sorna', 'name' => 'Isla Sorna'],
]);

$client->tenants()->bulkDelete(['isla-nublar', 'isla-sorna']);
```

### Audiences

```php
$client->audiences()->addMembers('park-staff', [
    ['user' => ['id' => 'jhammond'], 'tenant' => 'jurassic-park'],
], ['create_audience' => true]);

$client->audiences()->listMembers('park-staff');

$client->audiences()->removeMembers('park-staff', [
    ['user' => ['id' => 'jhammond'], 'tenant' => 'jurassic-park'],
]);
```

### Bulk creating schedules

```php
$client->workflows()->bulkCreateSchedules([
    [
        'workflow' => 'daily-digest',
        'recipient' => 'jhammond',
        'repeats' => [['frequency' => 'daily', 'hours' => 9]],
    ],
]);
```

### Guides

```php
$client->guides()->getUserGuides('jhammond', $guideChannelId, [
    'tenant' => 'jurassic-park',
    'data' => ['page' => 'visitor-center'],
]);

$client->guides()->markAsSeen('jhammond', [
    'channel_id' => $guideChannelId,
    'guide_id' => $guideId,
    'guide_key' => 'park-tour',
    'guide_step_ref' => 'welcome',
    'content' => ['title' => 'Welcome to Jurassic Park'],
]);
```

### Slack and Microsoft Teams providers

```php
$client->providers()->slackListChannels($slackChannelId, [
    'access_token_object' => ['collection' => 'parks', 'object_id' => 'jurassic-park'],
    'query_options' => ['limit' => 100],
]);

$client->providers()->msTeamsListTeams($msTeamsChannelId, [
    'ms_teams_tenant_object' => ['collection' => 'parks', 'object_id' => 'jurassic-park'],
]);
```

### Workflow recipient runs

```php
$client->workflowRecipientRuns()->list([
    'workflow' => 'dinosaurs-loose',
    'status' => ['completed'],
    'has_errors' => true,
]);

$client->workflowRecipientRuns()->get($workflowRecipientRunId);
```

### Canceling workflows

```php
$client->workflows()->cancel('dinosaurs-loose', [
    'cancellation_key' => '21e958bb-2517-40bb-aaaa-d40acc26dac3',
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

## Test
To run tests, first run `composer` in the terminal. Once compiled, you can run `phpunit tests/` to run the suite.

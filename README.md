<p align="center">
  <img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" alt="seven logo" />
</p>

<h1 align="center">seven SMS for CiviCRM</h1>

<p align="center">
  Two-way SMS provider for <a href="https://civicrm.org/">CiviCRM</a> - send Outbound SMS activities and receive inbound messages via webhook.
</p>

<p align="center">
  <a href="LICENSE.txt"><img src="https://img.shields.io/badge/License-MIT-teal.svg" alt="MIT License" /></a>
  <img src="https://img.shields.io/badge/CiviCRM-5.x-blue" alt="CiviCRM 5.x" />
  <img src="https://img.shields.io/badge/PHP-7.4%2B-purple" alt="PHP 7.4+" />
</p>

---

## Features

- **Outbound SMS Provider** - Available in **Contact > Outbound SMS** activities
- **Inbound SMS via Webhook** - `SmsProvider.receive` API endpoint creates activities for incoming messages
- **Activity Log Integration** - Sent SMS land in the regular CiviCRM activity log
- **Custom Sender ID** - Set per-provider via the *API Parameters* field

## Prerequisites

- [CiviCRM](https://civicrm.org/) 5.x
- A [seven account](https://www.seven.io/) with API key ([How to get your API key](https://help.seven.io/en/developer/where-do-i-find-my-api-key))

## Installation

```bash
cd /path/to/civicrm/ext
git clone https://github.com/seven-io/CiviCRM io.seven.sms
```

In the CiviCRM admin go to **Administer > System Settings > Extensions**, find *seven SMS provider* and click **Install**.

## Configuration

Add the seven SMS provider:

1. Go to **Administer > System Settings > SMS Providers**.
2. Click **Add SMS Provider**.

| Field | Value |
|-------|-------|
| Name | `seven` (defaults will load) |
| Title | Any label you like |
| Username | Any non-empty placeholder (field is unused but required) |
| Password | Your seven API key |
| API Type | `http` |
| API Url | `https://gateway.seven.io` |
| API Parameters | `from=CiviCRM` (or `from=` to omit) |

## Inbound SMS

Register a webhook in your seven [dashboard](https://app.seven.io/) (under *Developer > Webhooks*) pointing at the CiviCRM endpoint:

```
https://<your-civi>/civicrm/ajax/api3/SmsProvider/receive
```

> **Important:** The webhook event type must be set to **SMS_MO** in the seven dashboard.

You can also call the API manually:

```bash
cv api SmsProvider.receive sequential=1 from_number="01234" content="hello world"
```

## Usage

Send SMS via the standard CiviCRM workflow: **Contact > Outbound SMS** activity, or programmatically via the CiviCRM API.

Sent messages are recorded as regular activities in the contact's activity log.

## Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/) or [open an issue](https://github.com/seven-io/CiviCRM/issues).

## License

[MIT](LICENSE.txt)

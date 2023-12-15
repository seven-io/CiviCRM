<img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" />

# io.seven.sms

This CiviCRM extension provides a [seven](https://www.seven.io) SMS provider for
sending/receiving SMS.

## Installation

- `cd /path/to/civicrm/ext`
- `git clone https://github.com/seven-io/CiviCRM io.seven.sms`
- Go to `Administer->System Settings->Extensions`
- Locate `seven SMS provider`and press the `Install` button

## Setup

- Navigate to `Administer->System Settings->SMS Providers`
- Click the button `Add SMS Provider`
- `Name`: Choose `seven` and wait for the default values to load
- `Title`: Use whatever label makes sense to you
- `Username`: Use one of your seven API keys
- `Password`: Use the corresponding API secret for the API key
- `API Type`: Set this to `http`
- `API Url`: Make sure it's set to `https://gateway.seven.io`
- `API Parameters`: Set a custom sender ID like `from=CiviCRM` or omit the value
  e.g. `from=`

## Usage

To receive an SMS message use the SmsProvider.receive function:

```cv api SmsProvider.receive sequential=1 from_number="01234" content="hello world" ```

To send an SMS use the built-in CiviCRM functions (e.g. Contact->Outbound SMS activity).

Sent SMS messages will be added to the activity log.

**Important:** Make sure to use event *SMS_MO* when creating a seven webhook.

### Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE.txt)

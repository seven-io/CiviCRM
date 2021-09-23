# io.sms77.sms

This CiviCRM extension provides a [sms77](https://www.sms77.io) SMS provider for
sending/receiving SMS.

## Installation

- `cd /path/to/civicrm/ext`
- `git clone https://github.com/sms77io/CiviCRM io.sms77.sms`
- Go to `Administer->System Settings->Extensions`
- Locate `sms77 SMS provider`and press the `Install` button

## Setup

- Navigate to `Administer->System Settings->SMS Providers`
- Click the button `Add SMS Provider`
- `Name`: Choose `sms77` and wait for the default values to load
- `Title`: Use whatever label makes sense to you
- `Username`: Use one of your sms77 API keys
- `Password`: Use the corresponding API secret for the API key
- `API Type`: Set this to `http`
- `API Url`: Make sure it's set to `https://gateway.sms77.io`
- `API Parameters`: Set a custom sender ID like `from=CiviCRM` or omit the value
  e.g. `from=`

## Usage

To receive an SMS message use the SmsProvider.receive function:

```cv api SmsProvider.receive sequential=1 from_number="01234" content="hello world" ```

To send an SMS use the built-in CiviCRM functions (e.g. Contact->Outbound SMS activity).

Sent SMS messages will be added to the activity log.

### Support

Need help? Feel free to [contact us](https://www.sms77.io/en/company/contact/).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)

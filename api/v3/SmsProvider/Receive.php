<?php

/**
 * SmsProvider.Receive API specification (optional)
 * This is used for documentation and validation.
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_sms_provider_Receive_spec(&$spec) {
    $spec['content']['api.required'] = 1;
    $spec['content']['title'] = 'Content of SMS message';

    $spec['from_number']['api.required'] = 1;
    $spec['from_number']['description'] = 'Set to a phone number in the database if you want to match to a contact';
    $spec['from_number']['title'] = 'From number, can be set to any number';

    $spec['id']['description'] = 'can be set to any numeric value or left empty';
    $spec['id']['title'] = 'Id of message';
}

/**
 * SmsProvider.Receive API
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 * @see civicrm_api3_create_error
 * @see civicrm_api3_create_success
 */
function civicrm_api3_sms_provider_Receive($params) {
    require_once './../../../io_sms77_sms.php';

    if (!isset($params['id'])) $params['id'] = null;

    $res = io_sms77_sms::singleton()
        ->inbound($params['from_number'], $params['content'], $params['id']);

    if ($res && $res->id) {
        $params['id'] = $res->id;
        return civicrm_api3_create_success(
            [civicrm_api3('Activity', 'getsingle', $params)], $params, 'SmsProvider',
            'Receive');
    }

    return civicrm_api3_create_error('Inbound SMS processing failed');
}

<?php

require_once 'seven.civix.php';

/**
 * Implements hook_civicrm_config().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function seven_civicrm_config(&$config) {
    _seven_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function seven_civicrm_install() {
    civicrm_api3('option_value', 'create', [
        'is_active' => 1,
        'is_default' => 1,
        'label' => 'seven',
        'name' => 'seven',
        'option_group_id' => CRM_Core_DAO::getFieldValue(
            'CRM_Core_DAO_OptionGroup', 'sms_provider_name', 'id', 'name'),
        'value' => 'io.seven.sms',
        'version' => 3,
    ]);

    _seven_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function seven_civicrm_uninstall() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'seven', 'id', 'name');
    if ($optionID) CRM_Core_BAO_OptionValue::del($optionID);

    $Providers = seven_get_providers();
    foreach ($Providers as $v) CRM_SMS_BAO_Provider::del($v['id']);

}

/**
 * Implements hook_civicrm_enable().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function seven_civicrm_enable() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'seven', 'id', 'name');
    if ($optionID) CRM_Core_BAO_OptionValue::setIsActive($optionID, true);

    seven_set_active_provider(true);

    _seven_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function seven_civicrm_disable() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'seven', 'id', 'name');
    if ($optionID)
        CRM_Core_BAO_OptionValue::setIsActive($optionID, false);

    seven_set_active_provider(false);

}

function seven_set_active_provider(bool $active): void {
    $Providers = seven_get_providers();
    foreach ($Providers as $v) CRM_SMS_BAO_Provider::setIsActive($v['id'], $active);
}

function seven_get_providers(): array {
    $providers = CRM_SMS_BAO_Provider::getProviders(false, ['name' => 'io.seven.sms'], false);
    return $providers ?? [];
}

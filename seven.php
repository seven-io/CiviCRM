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
 * Implements hook_civicrm_xmlMenu().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function seven_civicrm_xmlMenu(&$files) {
    _seven_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function seven_civicrm_postInstall() {
    _seven_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function seven_civicrm_uninstall() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'seven', 'id', 'name');
    if ($optionID) CRM_Core_BAO_OptionValue::del($optionID);

    $Providers = CRM_SMS_BAO_Provider::getProviders(false, ['name' => 'io.seven.sms'], false);
    if ($Providers) foreach ($Providers as $v) CRM_SMS_BAO_Provider::del($v['id']);

    _seven_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function seven_civicrm_enable() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'seven', 'id', 'name');
    if ($optionID) CRM_Core_BAO_OptionValue::setIsActive($optionID, true);

    $Providers = CRM_SMS_BAO_Provider::getProviders(false, ['name' => 'io.seven.sms'], false);
    foreach ($Providers ?? [] as $v) CRM_SMS_BAO_Provider::setIsActive($v['id'], true);

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

    $Providers = CRM_SMS_BAO_Provider::getProviders(false, ['name' => 'io.seven.sms'], false);
    foreach ($Providers ?? [] as $v) CRM_SMS_BAO_Provider::setIsActive($v['id'], false);

    _seven_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function seven_civicrm_upgrade($op, CRM_Queue_Queue $queue = null) {
    return _seven_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function seven_civicrm_managed(&$entities) {
    _seven_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 * Generate a list of case-types.
 * Note: This hook only runs in CiviCRM 4.4+.
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function seven_civicrm_caseTypes(&$caseTypes) {
    _seven_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 * Generate a list of Angular modules.
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function seven_civicrm_angularModules(&$angularModules) {
    _seven_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function seven_civicrm_alterSettingsFolders(&$metaDataFolders = null) {
    _seven_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

<?php

require_once 'sms77.civix.php';

/**
 * Implements hook_civicrm_config().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function sms77_civicrm_config(&$config) {
    _sms77_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function sms77_civicrm_xmlMenu(&$files) {
    _sms77_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function sms77_civicrm_install() {
    civicrm_api3('option_value', 'create', [
        'is_active' => 1,
        'is_default' => 1,
        'label' => 'sms77',
        'name' => 'sms77',
        'option_group_id' => CRM_Core_DAO::getFieldValue(
            'CRM_Core_DAO_OptionGroup', 'sms_provider_name', 'id', 'name'),
        'value' => 'io.sms77.sms',
        'version' => 3,
    ]);

    _sms77_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function sms77_civicrm_postInstall() {
    _sms77_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function sms77_civicrm_uninstall() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'sms77', 'id', 'name');
    if ($optionID) CRM_Core_BAO_OptionValue::del($optionID);

    $Providers = CRM_SMS_BAO_Provider::getProviders(false, ['name' => 'io.sms77.sms'], false);
    if ($Providers) foreach ($Providers as $v) CRM_SMS_BAO_Provider::del($v['id']);

    _sms77_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function sms77_civicrm_enable() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'sms77', 'id', 'name');
    if ($optionID) CRM_Core_BAO_OptionValue::setIsActive($optionID, true);

    $Providers = CRM_SMS_BAO_Provider::getProviders(false, ['name' => 'io.sms77.sms'], false);
    foreach ($Providers ?? [] as $v) CRM_SMS_BAO_Provider::setIsActive($v['id'], true);

    _sms77_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function sms77_civicrm_disable() {
    $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue', 'sms77', 'id', 'name');
    if ($optionID)
        CRM_Core_BAO_OptionValue::setIsActive($optionID, false);

    $Providers = CRM_SMS_BAO_Provider::getProviders(false, ['name' => 'io.sms77.sms'], false);
    foreach ($Providers ?? [] as $v) CRM_SMS_BAO_Provider::setIsActive($v['id'], false);

    _sms77_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function sms77_civicrm_upgrade($op, CRM_Queue_Queue $queue = null) {
    return _sms77_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function sms77_civicrm_managed(&$entities) {
    _sms77_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 * Generate a list of case-types.
 * Note: This hook only runs in CiviCRM 4.4+.
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function sms77_civicrm_caseTypes(&$caseTypes) {
    _sms77_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 * Generate a list of Angular modules.
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function sms77_civicrm_angularModules(&$angularModules) {
    _sms77_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function sms77_civicrm_alterSettingsFolders(&$metaDataFolders = null) {
    _sms77_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

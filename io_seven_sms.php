<?php

/**
 * Class CRM_SMS_Provider_io_seven_sms
 */
class io_seven_sms extends CRM_SMS_Provider {
    const MAX_SMS_CHAR = 1520;
    /**
     * We only need one instance of this object. So we use the singleton
     * pattern and cache the instance in this variable
     * @var object $_singleton
     * @static
     */
    static private $_singleton = [];
    public $_apiURL = 'https://gateway.seven.io/api';
    /**
     * @var string $_providerInfo
     */
    protected $_providerInfo = [];
    protected $_id = 0;

    /** @return void */
    function __construct($provider, $skipAuth = true) {
        $this->_providerInfo = $provider;
    }

    /**
     * singleton function used to manage this object
     * @return object
     * @static
     */
    static function &singleton($providerParams = [], $force = false) {
        if (isset($providerParams['provider'])) {
            $providers = CRM_SMS_BAO_Provider::getProviders(null, ['name' => $providerParams['provider']]);
            $pID = current($providers)['id'];
        } else $pID = CRM_Utils_Array::value('provider_id', $providerParams);
        $cacheKey = (int)$pID;

        if (!isset(self::$_singleton[$cacheKey]) || $force) {
            $provider = [];
            if ($pID) $provider = CRM_SMS_BAO_Provider::getProviderInfo($pID);
            self::$_singleton[$cacheKey] = new io_seven_sms($provider, !$pID);
        }

        return self::$_singleton[$cacheKey];
    }

    /**
     * Send an SMS Message to a log file
     * @param array $recipients
     * @param string $header
     * @param string $message
     * @param null $jobID
     * @param null $userID
     * @return mixed SID on success or PEAR_Error object
     * @throws CRM_Core_Exception
     * @access public
     */
    function send($recipients, $header, $message, $jobID = null, $userID = null) {
        try {
            $to = $recipients;
            $res = $this->post(compact('message', 'recipients', 'to'));

            $needle = (int)$res['success'];
            $haystack = [100, 101];
            if (in_array($needle, $haystack)) {
                $id = null;
                foreach ($res['messages'] as $msg) {
                    $id = $msg['id'];
                    $this->createActivity($id, $message, $header, $jobID, $userID);
                }

                return $id;
            } else return PEAR::raiseError($res['success'], $res['success'], PEAR_ERROR_RETURN);
        } catch (Exception $e) {
            return PEAR::raiseError($e->getMessage(), $e->getCode(), PEAR_ERROR_RETURN);
        }
    }

    private function post(array $data): array {
        $data['from'] = $this->_providerInfo['api_params']['from'];
        $data['json'] = 1;
        $ch = curl_init($this->_apiURL . '/sms');
        $verifySSL = Civi::settings()->get('verifySSL');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $verifySSL ? 2 : 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $verifySSL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-type: application/json',
            'SentWith: CiviCRM',
            'X-Api-Key: ' . $this->_providerInfo['password'],
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    /**
     * @return CRM_SMS_Provider|object|null
     * @throws CRM_Core_Exception
     */
    function inbound() {
      $data = file_get_contents('php://input');

      if (mb_strlen($data)) {
        $obj = json_decode($data);
        $from = $obj->data->sender;
        $body = $obj->data->text;
        $trackID = $obj->data->id;
        $event = $obj->data->webhook_event;
      }
      else {
        $from = $this->retrieve('sender', 'String');
        $body = $this->retrieve('text', 'String');
        $trackID = $this->retrieve('id', 'String');
        $event = $this->retrieve('webhook_event', 'String');
      }

      if ($event !== 'sms_mo') return null;

        if (!$trackID) $trackID = date('YmdHis');

        return $this->processInbound($from, $body, null, $trackID);
    }
}

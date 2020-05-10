<?php

/**
 * Wrapper class to not restrict Membership API calls to the current domain.
 */
class CRM_Multisite_MembershipWrapper implements API_Wrapper {

  /**
   * Handle API Input
   *
   * @param array $apiRequest
   *
   * @return array
   */
  public function fromApiInput($apiRequest) {
    return $apiRequest;
  }

  /**
   * Handle returning results from API request
   * @param array $apiRequest
   * @param array $result
   *
   * @return array api result
   */
  public function toApiOutput($apiRequest, $result) {
    try {
      Civi::log()->debug('Req: {req}', ['req' => $apiRequest);
      Civi::log()->debug('Res: {res}', ['res' => $result);
      $types = civicrm_api3('MembershipType', 'get', [ 'domain_id' => null ]);
      if ($types['is_error'] == 0 && $types['count'] > 0) {
        $result['values'] = [];
        $result['count'] = $types['count'];
        foreach ($types['values'] as $key => $value) {
          $result['values'][$key] = $value['name'];
        }
      }
    } catch (CiviCRM_API3_Exception $e) {
      Civi::log()->error('API Membership Type lookup error');
    }
    return $result;
  }

}

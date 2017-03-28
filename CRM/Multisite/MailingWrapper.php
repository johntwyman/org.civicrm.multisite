<?php

/**
 *
 * Wrapper class to restrict Mailing API calls to the current domain.
 *
 **/
class CRM_Multisite_MailingWrapper implements API_Wrapper {
  public function fromApiInput($apiRequest) {
    if(empty($apiRequest['params']['params']['domain_id'])) {
      $apiRequest['params']['params']['domain_id'] = CRM_Core_Config::domainID();
    }

    return $apiRequest;
  }

  public function toApiOutput($apiRequest, $result) {
    return $result;
  }
}
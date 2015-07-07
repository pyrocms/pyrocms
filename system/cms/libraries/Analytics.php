<?php

require_once('system/cms/libraries/Gapi.php');

/**
 * Google Analytics library for PyroCMS
 *
 * Uses GAPI (https://github.com/erebusnz/gapi-google-analytics-php-interface) to access GA data
 *
 * @author Marco Grüter
 *
 * @version 1.0
 */

class Analytics {

	private $gapi;

	/**
	 * public constructor
	 *
	 * @param string $sUser
	 * @param string $sPass
	 * @return analytics
	 */
	public function __construct($parameters)
	{
		$this->gapi = new Gapi($parameters['email'], file_exists($parameters['key_file']) ? $parameters['key_file'] : FCPATH . APPPATH . 'config/ga-key.p12');
	}

	/**
	 * Sets GA Profile ID  (Example: ga:12345)
	 */
	public function setProfileById($sProfileId)
	{
		$this->_sProfileId = $sProfileId;
	}

	/**
	 * Sets the date range for GA data
	 *
	 * @param string $sStartDate (YYY-MM-DD)
	 * @param string $sEndDate   (YYY-MM-DD)
	 */
	public function setDateRange($sStartDate, $sEndDate)
	{
		$this->_sStartDate = $sStartDate;
		$this->_sEndDate = $sEndDate;
	}

	/**
	 * Sets de data range to a given month
	 *
	 * @param int $iMonth
	 * @param int $iYear
	 */
	public function setMonth($iMonth, $iYear)
	{
		$this->_sStartDate = date('Y-m-d', strtotime($iYear . '-' . $iMonth . '-01'));
		$this->_sEndDate = date('Y-m-d', strtotime($iYear . '-' . $iMonth . '-' . date('t', strtotime($iYear . '-' . $iMonth . '-01'))));
	}

	/**
	 * Get visitors for given period
	 *
	 */
	public function getVisitors()
	{
		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('date'), array('visits'), array('date'), null, $this->_sStartDate, $this->_sEndDate);

		$aData = array();

		foreach($gaData as $row)
		{
			$aData[$row->getDate()] = $row->getVisits();
		}

		return $aData;
	}

	/**
	 * Get pageviews for given period
	 *
	 */
	public function getPageviews()
	{
		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('date'), array('pageviews'), array('date'), null, $this->_sStartDate, $this->_sEndDate);

		$aData = array();

		foreach($gaData as $row)
		{
			$aData[$row->getDate()] = $row->getPageViews();
		}

		return $aData;		
	}


	/**
	 * Get referrers for given period
	 *
	 */
	public function getReferrers()
	{
		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('source'), array('visits'), array('source'), null, $this->_sStartDate, $this->_sEndDate);

		$aData = array();

		foreach($gaData as $row)
		{
			$aData[$row->getSource()] = $row->getVisits();
		}

		// sort descending by number of visits
		arsort($aData);
		return $aData;
	}

	/**
	 * Get search words for given period
	 *
	 */
	public function getSearchWords()
	{

		$gaData = $this->gapi->requestReportData($this->_sProfileId, array('keyword'), array('visits'), array('keyword'), null, $this->_sStartDate, $this->_sEndDate);

		$aData = array();

		foreach($gaData as $row)
		{
			$aData[$row->getKeyword()] = $row->getVisits();
		}		

		// sort descending by number of visits
		arsort($aData);
		return $aData;
	}
}
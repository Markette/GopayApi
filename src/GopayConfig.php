<?php

namespace Markette\Gopay\Api;

class GopayConfig
{

	/**
	 *  Konfiguracni trida pro ziskavani URL pro praci s platbami
	 */
	const TEST = 'TEST';
	const PROD = 'PROD';

	/**
	 * Parametr specifikujici, pracuje-li se na testovacim ci provoznim prostredi
	 *
	 * @var string
	 */
	public static $version = self::TEST;

	/**
	 * @var callable
	 */
	public static $soapClientFactory = '\Markette\Gopay\Api\SoapClientFactory::create';

	/**
	 * Nastaveni testovaciho ci provozniho prostredi prostrednictvim parametru
	 *
	 * TEST - Testovaci prostredi
	 * PROD - Provozni prostredi
	 *
	 * @param string $new_version
	 * @return void
	 */
	public static function init($new_version)
	{
		self::$version = $new_version;
	}

	/**
	 * URL platebni brany pro uplnou integraci
	 *
	 * @return string URL
	 */
	public static function fullIntegrationURL()
	{
		if (self::$version == self::PROD) {
			return 'https://gate.gopay.cz/gw/pay-full-v2';

		} else {
			return 'https://gw.sandbox.gopay.com/gw/pay-full-v2';
		}
	}

	/**
	 * URL webove sluzby GoPay
	 *
	 * @return string URL - wsdl
	 */
	public static function ws()
	{
		if (self::$version == self::PROD) {
			return 'https://gate.gopay.cz/axis/EPaymentServiceV2?wsdl';

		} else {
			return 'https://gw.sandbox.gopay.com/axis/EPaymentServiceV2?wsdl';

		}
	}

	/**
	 * Nové URL webove sluzby GoPay
	 *
	 * @return string URL - wsdl
	 */
	public static function fullNewIntegrationURL()
	{
		if (self::$version == self::PROD) {
			return 'https://gate.gopay.cz/gw/v3';

		} else {
			return 'https://gw.sandbox.gopay.com/gw/v3';

		}
	}

	/**
	 * URL platebni brany pro zakladni integraci
	 *
	 * @return string URL
	 */
	public static function baseIntegrationURL()
	{
		if (self::$version == self::PROD) {
			return 'https://gate.gopay.cz/gw/pay-base-v2';

		} else {
			return 'https://gw.sandbox.gopay.com/gw/pay-base-v2';

		}
	}

	/**
	 * URL pro stazeni vypisu plateb uzivatele
	 *
	 * @return string URL
	 */
	public static function getAccountStatementURL()
	{
		if (self::$version == self::PROD) {
			return 'https://gate.gopay.cz/gw/services/get-account-statement';

		} else {
			return 'https://gw.sandbox.gopay.com/gw/services/get-account-statement';

		}
	}

	/**
	 * @return \SoapClient
	 */
	public static function createSoapClient()
	{
		$soap = call_user_func(self::$soapClientFactory, self::ws());
		if ($soap instanceof \SoapClient) {
			return $soap;
		}

		throw new \UnexpectedValueException('SoapClient factory does not return instance of SoapClient.');
	}

}

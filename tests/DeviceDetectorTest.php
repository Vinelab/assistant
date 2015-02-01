<?php namespace Vinelab\Assistant\Tests;

use Vinelab\Assistant\DeviceDetector;
use PHPUnit_Framework_TestCase as TestCase;

Class DeviceDetectorTest extends TestCase {

	public function setUp()
	{
		$this->ass = new DeviceDetector;

		$this->mobile_browsers = array(
			'phone',
			'iphone',
			'ipad',
			'itouch',
			'ipod',
			'symbian',
			'android',
			'htc_',
			'htc-',
			'palmos',
			'blackberry',
			'opera mini',
			'iemobile',
			'windows ce',
			'nokia',
			'fennec',
			'hiptop',
			'kindle',
			'mot ',
			'mot-',
			'webos/',
			'samsung',
			'sonyericsson',
			'sie-',
			'nintendo'
		);

		$this->bots = array(
			'adsbot',
			'yahooseeker',
			'yahoobot',
			'msnbot',
			'watchmouse',
			'pingdom.com',
			'feedfetcher-google'
		);

		$this->sharing_bots = array(
			'googlebot',
			'facebookexternalhit',
			'Yahoo!',
			'Twitterbot',
			'Google-StructuredDataTestingTool',
			'https://developers.google.com/+/web/snippet',
		);

		$this->browsers = array('mozilla/', 'opera/');
	}

	public function testIsMobile()
	{
		foreach ($this->mobile_browsers as $user_agent)
		{
			$this->assertTrue($this->ass->isMobile($user_agent));
		}
	}

	public function testIsMobileCaseSensitivity()
	{
		foreach($this->mobile_browsers as $user_agent)
		{
			$this->assertTrue($this->ass->isMobile(strtoupper($user_agent)));
		}
	}

	public function testIsBrowser()
	{
		foreach ($this->browsers as $browser)
		{
			$this->assertTrue($this->ass->isBrowser($browser));
		}
	}

	public function testIsBrowserCaseSensitivity()
	{
		foreach ($this->browsers as $browser)
		{
			$this->assertTrue($this->ass->isBrowser(strtoupper($browser)));
		}
	}

	public function testIsBot()
	{
		foreach ($this->getBots() as $bot)
		{
			$this->assertTrue($this->ass->isBot($bot), "Bot: $bot");
		}
	}

	public function testIsBotCaseSensitivity()
	{
		foreach ($this->getBots() as $bot)
		{
			$this->assertTrue($this->ass->isBot(strtoupper($bot)), "Bot: $bot");
			$this->assertTrue($this->ass->isBot(strtolower($bot)), "Bot: $bot");
		}
	}

	public function testSharingBot()
	{
		foreach ($this->sharing_bots as $bot)
		{
			$this->assertTrue($this->ass->isSharingBot($bot), "Bot: $bot");
		}
	}

	public function testSharingBotCaseSensitivity()
	{
		foreach ($this->sharing_bots as $bot)
		{
			$this->assertTrue($this->ass->isSharingBot(strtoupper($bot)), "Bot: $bot");
			$this->assertTrue($this->ass->isSharingBot(strtolower($bot)), "Bot: $bot");
		}
	}

	public function testWhatIsMobile()
	{
		foreach ($this->mobile_browsers as $user_agent)
		{
			$this->assertEquals('mobile', $this->ass->whatIs($user_agent));
		}
	}

	public function testWhatIsBrowser()
	{
		foreach ($this->browsers as $browser)
		{
			$this->assertEquals('browser', $this->ass->whatIs($browser));
		}
	}

	public function testWhatIsBot()
	{
		foreach ($this->bots as $bot)
		{
			$this->assertEquals('bot', $this->ass->whatIs($bot), "Bot: $bot");
		}
	}

	public function testWhatIsSharingBot()
	{
		foreach ($this->sharing_bots as $bot)
		{
			$this->assertEquals('sharing-bot', $this->ass->whatIs($bot), "Bot: $bot");
		}
	}

	public function testOS()
	{
		$ios = array('iphone','itouch','ipod', 'ipad');
		$android = array('android', 'kindle');
		$blackberry = array('blackberry');
		$windows = array('windows ce', 'iemobile');
		$other = array('phone', 'symbian', 'palmos', 'nokia', 'webos');

		foreach($ios as $dev)
		{
			$this->assertEquals('ios', $this->ass->os($dev));
		}

		foreach($android as $dev)
		{
			$this->assertEquals('android', $this->ass->os($dev));
		}

		foreach($blackberry as $dev)
		{
			$this->assertEquals('blackberry', $this->ass->os($dev));
		}

		foreach($windows as $dev)
		{
			$this->assertEquals('windows', $this->ass->os($dev));
		}

		foreach($other as $dev)
		{
			$this->assertEquals('other', $this->ass->os($dev));
		}
	}

	protected function getBots()
	{
		return array_merge($this->bots, $this->sharing_bots);
	}

}

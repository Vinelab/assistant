<?php namespace Vinelab\Assistant\Tests;

use Vinelab\Assistant\DeviceDetector;
use PHPUnit_Framework_TestCase as TestCase;

Class DeviceDetectorTest extends TestCase {

	public function setUp()
	{
		$this->ass = new DeviceDetector;

		$this->mobile_browsers = ['phone','iphone','itouch','ipod','symbian','android','htc_','htc-','palmos','blackberry','opera mini','iemobile','windows ce','nokia','fennec','hiptop','kindle','mot ','mot-','webos/','samsung','sonyericsson','sie-','nintendo'];
		$this->bots            = ['googlebot','adsbot','yahooseeker','yahoobot','msnbot','watchmouse','pingdom.com','feedfetcher-google'];
		$this->browsers        = ['mozilla/', 'opera/'];
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
		foreach ($this->bots as $bot)
		{
			$this->assertTrue($this->ass->isBot($bot));
		}
	}

	public function testIsBotCaseSensitivity()
	{
		foreach ($this->bots as $bot)
		{
			$this->assertTrue($this->ass->isBot(strtoupper($bot)));
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
			$this->assertEquals('bot', $this->ass->whatIs($bot));
		}
	}

}
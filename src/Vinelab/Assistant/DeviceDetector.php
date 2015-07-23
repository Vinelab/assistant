<?php

namespace Vinelab\Assistant;

class DeviceDetector
{
    /**
     * matches popular mobile devices that have small screens and/or touch inputs
     * mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
     *detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here.
     *
     * @param string $user_agent
     *
     * @return bool
     */
    public function isMobile($user_agent)
    {
        // these are the most common
        if (preg_match("/phone|iphone|ipad|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/i", $user_agent)) {
            return true;
        // these are less common, and might not be worth checking
        } elseif (preg_match('/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /', $user_agent)) {
            return true;
        }
    }

    /**
     * Matches core browser types.
     *
     * @param string $user_agent
     *
     * @return bool
     */
    public function isBrowser($user_agent)
    {
        return (Boolean) preg_match("/mozilla\/|opera\//i", $user_agent);
    }

    /**
     * Matches popular bots (watchmouse|pingdom\.com are "uptime services").
     *
     * @param string $user_agent
     *
     * @return bool
     */
    public function isBot($user_agent)
    {
        $pattern = '/'.$this->getBotPattern().'|'.$this->getSharingBotPattern().'/i';

        return preg_match($pattern, $user_agent) > 0;
    }

    /**
     * Detect whether the visitor is a sharing bot.
     * Sharing bots are usually the crawlers from social networks that visit your website
     * when it's shared.
     *
     * @param string $user_agent
     *
     * @return bool
     */
    public function isSharingBot($user_agent)
    {
        $pattern = '/'.$this->getSharingBotPattern().'/i';

        return preg_match($pattern, $user_agent) > 0;
    }

    public function getBotPattern()
    {
        return 'googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google';
    }

    public function getSharingBotPattern()
    {
        return '.*(facebookexternalhit|Yahoo\!|(https:\/\/developers\.google\.com\/\+\/web\/snippet)|Googlebot|Twitterbot|Google\-StructuredDataTestingTool).*';
    }

    /**
     * Detects the device type.
     *
     * @param string $user_agent
     *
     * @return string
     */
    public function whatIs($user_agent)
    {
        if ($this->isMobile($user_agent)) {
            return 'mobile';
        }

        if ($this->isBrowser($user_agent)) {
            return 'browser';
        }

        if ($this->isSharingBot($user_agent)) {
            return 'sharing-bot';
        }

        if ($this->isBot($user_agent)) {
            return 'bot';
        }
    }

    /**
     * Detect the underlying operating system.
     *
     * @param string $user_agent
     *
     * @return string ios|android|windows|blackberry|other
     */
    public function os($user_agent)
    {
        if (preg_match('/iphone|itouch|ipod|ipad/i', $user_agent)) {
            return 'ios';
        }

        if (preg_match('/android|kindle/i', $user_agent)) {
            return 'android';
        }

        if (preg_match('/blackberry/i', $user_agent)) {
            return 'blackberry';
        }

        if (preg_match('/windows ce|iemobile|windows/i', $user_agent)) {
            return 'windows';
        }

        return 'other';
    }
}

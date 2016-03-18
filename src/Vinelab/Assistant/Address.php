<?php

namespace Vinelab\Assistant;

use Vinelab\Assistant\TldsTrait;

/**
 * @author Charalampos Raftopoulos <harris@vinelab.com>
 */
class Address
{
    use TldsTrait;

    /**
     * Return domain name.
     *
     * @param string $url
     *
     * @return array
     */
    public function domain($url)
    {
        $url = parse_url($url);

        if (!empty($url['host'])) {
            // grab domain with ports (if there are any) and pass it into an array, eg. test.api.najem.com
            $urlElements = explode('.', $url['host']);
        } else {
            // grab domain with ports (if there are any) and pass it into an array, eg. localhost
            $urlElements = explode('.', $url['path']);
        }

        // if domain array has one element only
        if (sizeof($urlElements) === 1) {
            // then that element is the domain's name
            $domain = $urlElements[sizeof($urlElements) - 1];
        } else {
            // get the second element from the end of the array (domains might have two levels at most, eg. co.uk)
            $secondLvl = strtoupper($urlElements[sizeof($urlElements) - 2]);

            // if the secondLvl exists inside the tld array
            if (array_search($secondLvl, $this->tlds) && (sizeof($urlElements) > 2)) {
                // get the previous element of the array, which will be our domain's name
                $domain = $urlElements[sizeof($urlElements) - 3];
            } else {
                // otherwise, we won't have second level domain and our domain's name will be the second element from the end
                $domain = $urlElements[sizeof($urlElements) - 2];
            }
        }

        return array($domain, $urlElements);
    }

    /**
     * Return subdomain names.
     *
     * @param string $url
     *
     * @return array
     */
    public function subdomain($url)
    {
        // get the domain name
        $domain = $this->domain($url);

        // number of the element the domain was found on
        $domainOn = array_search($domain[0], $domain[1]);

        // an array of the subdomains
        $subDomain = array_slice($domain[1], 0, $domainOn);

        return $subDomain;
    }

    /**
     * Return top-level domains.
     *
     * @param string $url
     *
     * @return array
     */
    public function tld($url)
    {
        // get the domain name
        $domain = $this->domain($url);

        // number of the element the domain was found on
        $domainOn = array_search($domain[0], $domain[1]);

        // an array of the tlds
        $tlds = array_slice($domain[1], $domainOn + 1, $domainOn + 1);

        return $tlds;
    }

    /**
     * Return hostname.
     *
     * @param string $url
     *
     * @return string
     */
    public function hostname($url)
    {
        $url = parse_url($url);

        // get hostname from the url
        $hostname = $url['host'];

        return $hostname;
    }
}

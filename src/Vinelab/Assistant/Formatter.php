<?php

namespace Vinelab\Assistant;

class Formatter
{
    /**
     * Turn a word into snake_case.
     *
     * @param string $word the word to snakify
     *
     * @return string
     */
    public function snakify($word)
    {
        return mb_strtolower(str_replace(' ', '_', $word));
    }

    /**
     * Turn a word into CamelCase.
     *
     * @param string $word The word to camelify
     *
     * @return string
     */
    public function camelify($word)
    {
        preg_match('/\s/', $word, $matches, PREG_OFFSET_CAPTURE);

        if (count($matches) > 0) {
            $ending = str_replace(' ', '', ucwords(str_replace('_', ' ', substr($word, $matches[0][1]))));
            $beginning = mb_strtolower(substr($word, 0, $matches[0][1]));

            return $beginning.$ending;
        } else {
            return $word;
        }
    }

    /**
     * Removes spaces, dashes, dots, commas and underscores from the given string.
     *
     * @param string $string
     *
     * @return string
     */
    public function neutralize($string)
    {
        return preg_replace('/\s|-|\.|,|_/i', '', mb_strtolower($string));
    }

    /**
     * Turns all spaces into dashes in a string.
     *
     * @param string $string
     *
     * @return string
     */
    public function dashit($string)
    {
        return mb_strtolower(str_replace(' ', '-', $string));
    }

    /**
     * Multi-unicode compliant ucfirst.
     *
     * @param  string $string
     * @param  string $encoding
     *
     * @return string
     */
    public function ucfirst($string, $encoding = 'UTF-8')
    {
        $encoding = mb_internal_encoding($encoding);
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);

        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    /**
     * Multi-unicode compliant lcfirst.
     *
     * @param  string $string
     * @param  string $encoding
     *
     * @return string
     */
    public function lcfirst($string, $encoding = 'UTF-8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);

        return mb_strtolower($firstChar, $encoding) . $then;
    }

    /**
     * Formats a date into a given pattern - default is d/m/y
     * Mostly used when printing.
     *
     * @param string $date
     * @param string $pattern your choice of these http://php.net/manual/en/function.date.php
     *
     * @return string
     */
    public function date($date, $pattern = null)
    {
        $default_pattern = 'd/m/y';

        if (empty($date)) {
            return date($pattern ?: $default_pattern);
        }

        return !is_null(strtotime($date)) ? date($pattern ?: $default_pattern, strtotime($date)) : null;
    }

    /**
     * Transforms a camelCase string to snake-case
     *
     * @param string $string
     *
     * @return string
     */
    public function aliasify($string)
    {
        preg_match_all('/([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)/', $string, $matches);

        if (strlen($string) > 0 && empty(reset($matches))) {
            // probably UTF-8 characters?
            preg_match_all('/^[\x{0600}-\x{06FF}]+/u', $string, $matches);
        }

        $result = $matches[0];

        foreach ($result as &$match) {
            $match = ($match == mb_strtoupper($match)) ? mb_strtolower($match) : $this->lcfirst($match);
        }

        return implode('-', $result);
    }

    /**
     * Convert <br> to \n.
     *
     * @param string $html
     *
     * @return string
     */
    public function br2nl($html)
    {
        return preg_replace('~<\s*br\s*/?>~', "\n", $html);
    }

    /**
     * Convert <div> to <br>.
     *
     * @param string $html
     *
     * @return string
     */
    public function div2br($html)
    {
        return preg_replace('~<div>~', '<br>', $html);
    }

    /**
     * Transform a normal HTML into
     * a stripped HTML removing tags and attributes
     * except the href in anchor tags.
     *
     * @param string $html
     *
     * @return string
     */
    public function cleanHTML($html)
    {
        $text = preg_replace('~</(p|div|h[0-9])>~', '</$1><br />', $html);

        $text = $this->div2br($text);

        $text = strip_tags($text, '<a><br><b><strike><u><i>');

        $text = $this->br2nl($text);

        // remove tag attributes except <a>
        $text = preg_replace('~<(?!a\s)([a-z][a-z0-9]*)[^>]*?(/?)>~i', '<$1$2>', $text);
        // remove all attributes from <a> except 'href'
        $text = preg_replace('~<a\s.*(href=.*)>~i', '<a $1>', $text);
        $text = preg_replace('/class=".*?"/', '', $text);
        $text = preg_replace('/style=".*?"/', '', $text);

        return $text;
    }
}

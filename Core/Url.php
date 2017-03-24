<?php namespace DrMVC\Core;

/**
 * Class Url for manipulations with url, like redirection or parse
 * @package System\Core
 */
class Url
{
    /**
     * Redirect to chosen url
     *
     * @param  string $url the url to redirect to
     * @param  bool   $fullpath if true use only url in redirect instead of using DIR
     */
    public static function redirect($url = null, $fullpath = false)
    {
        if ($fullpath == false) {
            $url = URL . DIR . $url;
        }

        header('Location: ' . $url);
        exit;
    }

    /**
     * Converts plain text urls into HTML links, second argument will be
     * used as the url label <a href=''>$custom</a>.
     *
     * @param  string $text data containing the text to read
     * @param  string $custom if provided, this is used for the link label
     * @return string         returns the data with links created around urls
     */
    public static function autoLink($text, $custom = null)
    {
        $regex = '@(http)?(s)?(://)?(([-\w]+\.)+([^\s]+)+[^,.\s])@';

        if ($custom === null) {
            $replace = '<a href="http$2://$4">$1$2$3$4</a>';
        } else {
            $replace = '<a href="http$2://$4">' . $custom . '</a>';
        }

        return preg_replace($regex, $replace, $text);
    }

    /**
     * This function converts and url segment to an safe one, for example:
     * `test name @132` will be converted to `test-name--123`
     * Basically it works by replacing every character that isn't an letter or an number to an dash sign
     * It will also return all letters in lowercase.
     *
     * @param  string $slug the url slug to convert
     * @return mixed|string
     */
    public static function generateSafeSlug($slug)
    {
        setlocale(LC_ALL, "en_US.utf8");

        $slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));

        $slug = htmlentities($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $slug = preg_replace($pattern, '$1', $slug);

        $slug = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~[^0-9a-z]+~i';
        $slug = preg_replace($pattern, '-', $slug);

        return strtolower(trim($slug, '-'));
    }

    /**
     * Go to the previous url
     */
    public static function previous()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    /**
     * Return previous url
     */
    public static function getPrevious()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * Get all url parts based on a / separator
     *
     * @return array of segments
     */
    public static function segments()
    {
        return explode('/', $_SERVER['REQUEST_URI']);
    }

    /**
     * Get item in array
     *
     * @param  array $segments array
     * @param  int   $id array index
     * @return string
     */
    public static function getSegment($segments, $id)
    {
        if (array_key_exists($id, $segments)) {
            return $segments[$id];
        } else {
            return false;
        }
    }

    /**
     * Get last item in array
     *
     * @param  array $segments
     * @return string
     */
    public static function lastSegment($segments)
    {
        return end($segments);
    }

    /**
     * Get first item in array
     *
     * @param  array $segments
     * @return string
     */
    public static function firstSegment($segments)
    {
        return $segments[0];
    }
}
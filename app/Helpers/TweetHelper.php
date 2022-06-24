<?php
if (!function_exists('get_tweet_id')) {
    function get_tweet_id($url){
        try {
            //validar si es una url
            if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
                $clean_url = $url;
                $clean_url =str_replace('http://','',$clean_url);
                $clean_url =str_replace('https://','',$clean_url);
                $clean_url =str_replace('www.','',$clean_url);

                $url_parts = explode('/', $clean_url);
                if($url_parts[0]!='twitter.com'||$url_parts[2]!='status'){
                    return -1;
                }
                $id_parts = explode('?', end($url_parts));
                $id=$id_parts[0];
                return $id;
            } else {
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }
}

if (!function_exists('hours_between')) {
    function hours_between($hour1,$hour2){
        return abs($hour1-$hour2)/(60*60);
    }
}

?>
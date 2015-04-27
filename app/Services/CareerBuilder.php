<?php

namespace App\Services;

class CareerBuilder {
    
    protected $cache;
    protected $client;
    private $devkey = "WDHQ43364147NGQQZP5R";
    
    public function __construct(\Illuminate\Cache\Repository $cache, $client) {
        $this->cache = $cache;
        $this->client = $client;
    }

    public function getJobs($url, $cache_string) {
        if ($this->cache->has($cache_string)) {
            return json_decode($this->cache->get($cache_string));
        }
        
        $url = "http://api.careerbuilder.com/v1/jobsearch?DeveloperKey=" . $this->devkey . "&JobTitle=intern" . $url;
        $xml = simplexml_load_string(file_get_contents($url));
        $json = json_encode($xml);
        
        $this->cache->put($cache_string, $json, 180);
        return json_decode($json);
    }
    
}

?>
<?php

use App\Models\Company;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

class CompanyTest extends TestCase {
    
    public function testValidateReturnsFalseIfCompanyNameIsMissing() {
        $validation = Company::validate([
            'name' => '',
            'icon' => 'some url'
        ]);
        $this->assertEquals($validation->passes(), false);
    }
    
    public function testValidateReturnsTrueIfCompanyNameIsPresent() {
        $validation = Company::validate([
            'name' => 'Company Name',
            'icon' => 'some url'
        ]);
        $this->assertEquals($validation->passes(), true);
    }
    
    public function tearDown() {
        Mockery::close();
    }
    
    public function testRecommendPercentNoReviews() {
        $company = new Company();
        $results = $company->recommend_percent();
        $this->assertEquals($results, 0);
    }
    
    public function testSearchPullsFromCache() {
        $json = '{"total": 0, "jobs":[]}';
        $client = Mockery::mock('App\Services\Client');

        $cache = Mockery::mock('Illuminate\Cache\Repository');
        $cache->shouldReceive('has')->with('jobs-all')->andReturn(true);
        $cache->shouldReceive('get')->with('jobs-all')->andReturn($json);
        
        $cb = new App\Services\CareerBuilder($cache, $client);
        $results = $cb->getJobs("", 'jobs-all');
        $this->assertEquals($results, json_decode($json)); 
    }
}





















?>
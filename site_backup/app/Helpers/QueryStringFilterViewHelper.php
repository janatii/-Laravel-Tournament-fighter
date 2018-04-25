<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class QueryStringFilterViewHelper
{
    /**
     * @var Request
     */
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * Strict comparaison of query string parameter value
     * 
     * @param $paramName
     * @param $value
     * @return bool
     */
    public function check($paramName, $value)
    {
        $paramValue = $this->request->query($paramName);
        
        if ($paramValue === null) {
            return $value === null;
        }
        
        return $paramValue == $value;
    }
    
    /**
     * Remove query string parameter
     * 
     * @param $paramName
     * @return string
     */
    public function currentUrlWithout($paramName)
    {
        return $this->currentUrlWith($paramName, null);
    }
    
    /**
     * Set query string parameter (remove if value is null)
     * 
     * @param $paramName
     * @param $value
     * @return string
     */
    public function currentUrlWith($paramName, $value)
    {
        return $this->request->fullUrlWithQuery(['page' => null, $paramName => $value]);
    }
}

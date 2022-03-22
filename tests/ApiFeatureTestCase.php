<?php

namespace Tests;

class ApiFeatureTestCase extends FeatureTestCase
{
    public function get($uri, array $headers =
    ['Content-Type' => 'application/json', 'Accept' => 'application/json'])
    {
        return parent::get($uri, $headers);
    }
}

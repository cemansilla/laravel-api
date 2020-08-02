<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $base_url = "/api/v1/";

    /**
     * Sobreescribo método de BaseTestCase
     * Sirve para que en cada petición llame a mi método de autenticación
     */
    public function setUp():void{
        parent::setUp();

        $this->signIn();
    }

    /**
     * Método para uso de autenticación Passport
     */
    public function signIn(){
        Passport::actingAs(create('App\User'));
    }
}

<?php

namespace App\Providers;

use Code\Validator\Cpf;
use Code\Validator\Cnpj;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Evita erros com as versões mais antigas do mysql
        \Schema::defaultStringLength(191);

        //evita o erro do tipo enum que não existe no mysql
        $platform = \Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
        //converte o tipo enum para o tipo string
        $platform->registerDoctrineTypeMapping('enum', 'string');

        \Validator::extend('document_number', function ($attribute, $value, $parameters, $validator) {
            $documentValidator = $parameters[0] == 'cpf'?new Cpf():new Cnpj();
            return $documentValidator->isValid($value);
        });
    }
}

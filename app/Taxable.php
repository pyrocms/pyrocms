<?php namespace App;

use Anomaly\UsersModule\User\UserModel;

class Taxable extends UserModel
{

    public function getTaxableCountry()
    {
        return 'US';
    }

    public function getTaxableState()
    {
        return 'IL';
    }

    public function getTaxablePostalCode()
    {
        return '61241';
    }
}

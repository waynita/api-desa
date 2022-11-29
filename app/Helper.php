<?php

use App\Models\Family;
use App\Models\User;

if ( ! function_exists('getUserHelper'))
{
    function getUserHelper($id, $environment = null)
    {
        $Data = User::select(
            // user
            'users.id as id',
            'users.name as name',
            'users.gender as gender',
            'users.birthdate as birthdate',
            'users.created_at as created_at',
            'users.updated_at as updated_at',

            // Population
            "population.id as population_id",
            "population.nik as nik",
            "population.address as address",
            "population.district as district",
            "population.place_of_birth as place_of_birth",
            "population.gender as gender",
            "population.village as village",
            "population.neighbourhood as neighbourhood",
            "population.hamlet as hamlet",
            "population.religion as religion",
            "population.married as married",
            "population.relation as relation",
            "population.occupation as occupation",
            "population.status as status",

            // Population
            "family.id as family_id",
            'family.number_family as number_family',
            'family.head_id as head_id',
            'family.village as familyvillage',
            'family.sub_districts as sub_districts',
            'family.districts as districts',
            'family.province as province',

            )->join("population", "population.user_id", "users.id")
            ->leftjoin("family", "users.family_id", "family.id");
        
        if (isset($environment)) {
            if ($environment == 'family') {
                $Data = $Data->where('family.id', $id);
            }

            if ($environment == 'user') {
                $Data = $Data->where('users.id', $id);
            }

            if ($environment == 'userStrict') {
                $Data = $Data->where('users.id', $id)->where('users.status', 'active');
            }
        }

        $Data = $Data->first();
        return $Data;
    }
}

if ( ! function_exists('getFamilyHelper'))
{
    function getFamilyHelper($id, $environment = null)
    {
        $Data = Family::select(
            // family
            'family.id as id',
            'family.number_family as number_family',
            'family.head_id as head_id',
            'family.village as village',
            'family.sub_districts as sub_districts',
            'family.districts as districts',
            'family.province as province',
            'family.hamlet as hamlet',
            'family.neighbourhood as neighbourhood',

            // user
            'users.id as user_id',
            'users.name as head'
        )
        ->join('users', 'family.head_id', 'users.id');

        
        if (isset($environment)) {
            if ($environment == 'family') {
                $Data = $Data->where('family.id', $id);
            }
        }

        $Data = $Data->first();
        return $Data;
    }
}
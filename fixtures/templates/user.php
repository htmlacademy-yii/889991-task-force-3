<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
   'user_name' => $faker->name,
   'email' => $faker->email,
   'city_id' => $faker->numberBetween(1, 1000),
   'user_password' => $faker->password(),
];
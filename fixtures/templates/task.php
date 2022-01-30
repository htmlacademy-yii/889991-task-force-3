<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
   'title' => $faker->sentence,
   'task_description' => $faker->paragraph(5),
   'budget' => $faker->numberBetween(100, 10000),
   'period_execution' => $faker->dateTimeInInterval('now', '+10 days')->format('Y-m-d'),
   'city_id' => $faker->numberBetween(1, 1000),
   'user_id' => $faker->numberBetween(1, 10),
   'category_id' => $faker->numberBetween(1, 8)
];
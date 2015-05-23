<?php
use app\models\Project;

/**
 * @var $faker Faker\Generator
 * @var $index integer
 */

return [
    'title' => $faker->sentence(),
    'alias' => $faker->slug,
    'shortDescription' => $faker->sentence(),
    'description' => $faker->paragraph(6),
    'isPublished' => Project::PUBLISHED,
    'rating' => 0,
    'createdAt' => time(),
    'updatedAt' => time(),
];
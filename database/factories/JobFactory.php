<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title=$this->faker->jobTitle();
        $url=$this->faker->url();
        $description=$this->faker->realText();
        $date=$this->faker->date('Y-m-d H:i:s');
        $location=$this->faker->country();
        $company=$this->faker->company();

        return [
            'title' => $title,
            'url' => $url,
            'description' => $description,
            'posted_date' => $date,
            'location' => $location,
            'company' => $company,
            'source' => $this->faker->numberBetween(0, 10),
            'is_scraped' => $this->faker->numberBetween(0, 1),
            'is_published' => $this->faker->numberBetween(0, 1),
        ];
    }
}

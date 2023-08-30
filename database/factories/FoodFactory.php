<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $foodName = "";

    // @override
    public function factory($foodName = "", ...$args): Factory
    {
        $this->$foodName = $foodName;
        return parent::factory(...$args);
    }

    public function definition(): array
    {
        return [
            // 'name' => $this->faker->word,
            // 'description' => $this->faker->text,
            // 'price' => $this->faker->randomFloat(2, 0, 999999.99),
            // 'image' => $this->getImage("https://loremflickr.com/640/480/". $this->foodName )
        ];
    }

    public function getImage( $url ): string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
        //return $this->faker->imageUrl(640, 480);
    }

}

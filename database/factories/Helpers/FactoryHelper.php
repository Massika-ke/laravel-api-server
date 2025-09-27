<?php

namespace Database\Factories\Helpers;

use App\Models\Post;
Use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryHelper
{
    /**
     * This function will get a random id from the database
     * @param string | HasFactory $model
     *
     */
    public static function getRandomModelId(string $model)
    {
        // $count = $model::query()->count(); 
        // {
        //     $count === 0 ? $model::factory()->create()->id : rand(1, $count);
        // }
          // get model count
        $count = $model::query()->count();

        if ($count === 0) {
            # create a new record and retrive the record id
            return $model::factory()->create()->id;
        }else{
            // generate random number between 1 and the model count
            return rand(1, $count);
        }
        
    }
}
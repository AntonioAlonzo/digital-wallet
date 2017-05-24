<?php

namespace App\Transformers;

use App\Category;
use Flugg\Responder\Transformer;

class CategoryTransformer extends Transformer
{
    /**
     * A list of all available relations.
     *
     * @var array
     */
    protected $relations = ['*'];

    /**
     * Transform the model data into a generic array.
     *
     * @param  Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => (int)$category->id,
            'name' => (string)$category->name,
            'type' => (string)$category->type,
        ];
    }
}

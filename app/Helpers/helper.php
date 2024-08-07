<?php

use App\Models\Category;

function getCategories()
{
    return Category::orderBy('name', 'asc')
        ->with('sub_category')
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->where('showHome', 'Yes')->get();
}
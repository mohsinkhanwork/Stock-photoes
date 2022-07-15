<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [

        'name',
        'status',
        'image',
        'sort',
    ];

    public function subcategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public static function getLastSortNumber()
    {
        $leastSortRecords = Category::orderBy('sort', 'desc')->first();
        return $leastSortRecords->sort;
    }

    public static function sortLogo($mode, $id)
    {
        $logo = Category::find($id);
        if (isset($logo->id) && !empty($logo->id)) {
            $currentSort = $logo->sort;
            if ($mode == 'up') {
                $newSort = ($currentSort - 1);
            } elseif ($mode == 'down') {
                $newSort = ($currentSort + 1);
            }
            if (isset($newSort)) {
                $sortedLogo = Category::where('sort', $newSort)->first();
                if (isset($sortedLogo->id) && !empty($sortedLogo->id)) {
                    $sortedLogo->sort = $currentSort;
                    $sortedLogo->save();
                }
                $logo->sort = $newSort;
                $logo->save();
            }
        }
    }
}

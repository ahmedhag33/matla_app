<?php

namespace App\Scopes;

use App\Triats\GeneralTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class LanguageScope implements Scope
{
  use GeneralTrait;

  /**
   * Apply the scope to a given Eloquent query builder.
   * this scope use to colums with user use language
   * 
   * @param  \Illuminate\Database\Eloquent\Builder  $builder
   * @param  \Illuminate\Database\Eloquent\Model  $model
   * @return void
   */
  public function apply(Builder $builder, Model $model)
  {
    $result = [];

    $dash = '_';

    $lang = $this->GetCurrentLanguage();

    $fillable = $model->getFillable();

    $array = array_filter($fillable, function ($value) {

      $result  = strpos($value, 'ar');
      $result .= strpos($value, 'en');
      return $result == false;
    });

    foreach ($fillable as $value) {

      if (strstr($value, $lang)) {

        $replace_value = substr($value, 0, -3);
        $getvaluewithlang = $replace_value . $dash . $lang . ' as ' . $replace_value;
        $result[] = $getvaluewithlang;
        $select = array_merge($array, $result);
      }
    }

    $builder->select($select);
  }
}

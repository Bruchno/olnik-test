<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hous extends Model
{

    public static function searchHouses($request){
      $input = [];
      $input['name'] = $request->input('name');
      $input['price_from'] = (int)trim($request->post('price_from'));
      $input['price_to'] = (int)trim($request->post('price_to'));
      $input['bedrooms'] = (int)trim($request->post('bedrooms'));
      $input['bathrooms'] = (int)trim($request->post('bathrooms'));
      $input['storeys'] = (int)trim($request->post('storeys'));
      $input['garages'] = (int)trim($request->post('garages'));
      if($input['name'] != '' ||
         $input['price_from'] != 0 ||
         $input['price_to'] != 0 ||
         $input['bathrooms'] != 0 ||
         $input['bedrooms'] != 0 ||
         $input['storeys'] != 0 || $input['garages'] != 0){
          $arr_serch = [];
          foreach ($input as $key => $value) {
            if($key == 'name' && $value != ''){
              $arr_serch[] = ['name', 'like', "%{$value}%"];
            } else if($key == 'price_from' && $value != 0){
              $arr_serch[] = ['price', '>', $value];
            } else if ($key == 'price_to' && $value != 0) {
              $arr_serch[] = ['price', '<', $value];
            } else if($value != 0){
              $arr_serch[] = [$key, '=', $value];
            }
          }
                     }
      $houses = Hous::where($arr_serch)->get();
      return $houses;
    }
}

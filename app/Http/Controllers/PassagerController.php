<?php

namespace App\Http\Controllers;

use App\Models\passager;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;
class PassagerController extends Controller
{

    public function index()
    {
      return passager::select('id','lastName','FirstName','address','city','tel','cin','client','cood_gps','country','code')->get();
    }

    public function is_parameter($parameter) {
        return isset($_GET[$parameter]);
      }

 // Create the new passager
      public function createPassager(Request $request)
      {
          $id = 0;
          if (isset($_GET["u"])) {
              try {
                  $d = json_decode($_GET["u"]);
                 
                  if ($d->lastName != "" && $d->FirstName != "" && $d->tel != "" && $d->cin != "" && $d->code != "") {
                    
                      $existingPassager = passager::where('code', $d->code)->first();
                      if ($existingPassager) {
                          return response(['message' => 'Passager with code ' . $d->code . ' already exists'], 400);
                      }
  
                 
                      $data = array(
                          'lastName' => $d->lastName,
                          'FirstName' => $d->FirstName,
                          'address' => $d->address,
                          'tel' => $d->tel,
                          'cin' => $d->cin,
                          'city' => $d->city,
                          'country' => $d->country,
                          'client' => $d->client,
                          'cood_gps' => $d->cood_gps,
                          'code' => $d->code,
                      );
                      $id = passager::insertGetId($data);
                      return response(['message' => 'Added Successfully', "id" => $id], 200);
                  } else {
                      return response(['message' => 'Missing fields'], 400);
                  }
              } catch (Exception $e) {
                  echo 'Message: ' . $e->getMessage();
                  return response(['message' => 'Error'], 500);
              }
          } else {
              return response(['message' => 'Missing parameter'], 400);
          }
      }
  
      /******************************update passager**************************************/
      public function editPassager(Request $request)
      {
          if (isset($_GET["e"])) {
              $d = json_decode($_GET["e"]);
  
              if ($d->lastName != "" && $d->FirstName != "" && $d->tel != "" && $d->cin != "" && $d->code != "") {
         
                  $existingPassager = passager::where('code', $d->code)->where('id', '!=', $d->id)->first();
                  if ($existingPassager) {
                      return response(['message' => 'Passager with code ' . $d->code . ' already exists'], 400);
                  }
  
               
                  $data = array(
                      'lastName' => $d->lastName,
                      'FirstName' => $d->FirstName,
                      'address' => $d->address,
                      'tel' => $d->tel,
                      'cin' => $d->cin,
                      'city' => $d->city,
                      'country' => $d->country,
                      'client' => $d->client,
                      'cood_gps' => $d->cood_gps,
                      'code' => $d->code,
                  );
                  try {
                      Passager::where('id', $d->id)->update($data);
                  } catch (Exception $e) {
                      echo 'Message: ' . $e->getMessage();
                      return response(['message' => 'Passager : ' . $d->lastName . ' ' . $d->FirstName . ' already exists'], 400);
                  }
                  return response(['message' => 'Updated Successfully'], 200);
              } else {
                  return response(['message' => 'Missing fields'], 400);
              }
          } else {
              return response(['message' => 'Missing parameter'], 400);
          }
      }
   
    /******************************Aficher passager**************************************/

    public function loadPassager(Request $request)
    {
        $where = "1=1";



        if ($request->has('client') && $request->has('city')) {
         
            $clientsAndCities = Passager::where('client',$request->client)->where(function($q) use ($request){
                $q->where('city',$request->city);

            })->get();
            return response($clientsAndCities, 200);
        }

        if ($request->has('c')) {
            $c = $request->input('c');
            $where .= " AND id = '" . $c . "'";
        }

        $passagers = Passager::select('id', 'lastName', 'FirstName', 'address', 'city', 'tel', 'cin', 'client', 'cood_gps', 'country', 'code')
            ->whereRaw($where)
            ->get();

            return response($passagers, 200);
 
    }
/******************************delete passager**************************************/
    public function deletepassager(Request $request)
    {


    $passagerId = $request->get('id');
    if (!$passagerId) {
      return response(['message' => 'ID de passager manquant'], 400);
    }

    $passager = Passager::where('id', $passagerId)->first();


    if (!$passager) {
      return response(['message' => 'Passager introuvable'], 404);
    }

    $passager->delete();

    return response(['message' => 'Passager supprimé avec succès'], 200);
  }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Requests\CarStoreRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // All Product
       $cars = Car::all();
     
       // Return Json Response
       return response()->json([
          'products' => $cars
       ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarStoreRequest $request)
    {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
     
            // Create Product
            Car::create([
                'name' => $request->name,
                'type_id' => $request->type_id,
                'image' => $imageName
            ]);
     
            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
     
            // Return Json Response
            return response()->json([
                'message' => "Mobil berhasil dibuat."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Terjadi Kesalahan!"
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // Product Detail 
       $car = Car::find($id);
       if(!$car){
         return response()->json([
            'message'=>'Mobil tidak ditemukan.'
         ],404);
       }
     
       // Return Json Response
       return response()->json([
          'product' => $car
       ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarStoreRequest $request, $id)
    {
        try {
            // Find product
            $car = Car::find($id);
            if(!$car){
              return response()->json([
                'message'=>'Product Not Found.'
              ],404);
            }
     
            $car->name = $request->name;
            $car->type_id = $request->type_id;
     
            if($request->image) {
                // Public storage
                $storage = Storage::disk('public');
     
                // Old iamge delete
                if($storage->exists($car->image))
                    $storage->delete($car->image);
     
                // Image name
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $car->image = $imageName;
     
                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }
     
            // Update Product
            $car->save();
     
            // Return Json Response
            return response()->json([
                'message' => "Product successfully updated."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Detail 
        $car = Car::find($id);
        if(!$car){
          return response()->json([
             'message'=>'Mobil tidak ditemukan.'
          ],404);
        }
     
        // Public storage
        $storage = Storage::disk('public');
     
        // Iamge delete
        if($storage->exists($car->image))
            $storage->delete($car->image);
     
        // Delete Product
        $car->delete();
     
        // Return Json Response
        return response()->json([
            'message' => "Product successfully deleted."
        ],200);
    }
}

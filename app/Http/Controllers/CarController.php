<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'type' => 'required',
            'color' => 'required',
            'person' => 'required',
            'available' => 'required',
            'price' => 'required',
            'image' => 'mimes:png,jpeg,jpg|max:2048',
        ]);

        $filePath = public_path('uploads');
        $insert = new Car();
        $insert->model = $request->model;
        $insert->type = $request->type;
        $insert->color = $request->color;
        $insert->person = $request->person;
        $insert->available = $request->available;
        $insert->price = $request->price;

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();

            $file->move($filePath, $file_name);
            $insert->image = $file_name;
        }

        $result = $insert->save();
   
        return redirect()->route('cars.index')
                        ->with('success','Car added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cars = Car::findOrFail($id);
        return view('cars.show',compact('cars'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cars = Car::findOrFail($id);
        return view('cars.edit', compact('cars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'model' => 'required',
            'type' => 'required',
            'price' => 'required',
            'color' => 'required',
            'person' => 'required',
            'available' => 'required',
            'image' => 'nullable|mimes:png,jpeg,jpg|max:2048',
        ]);
        
        $cars = Car::findOrFail($id);

        if ($request->hasFile('image')) {
            $filePath = public_path('uploads');
            $file = $request->file('image');
            $file_name = time() . '_' .$file->getClientOriginalName();
            $file->move($filePath, $file_name);
            // delete old photo
            if (!is_null($cars->image)) {
                $oldImage = public_path('uploads/' . $cars->image);
                if (File::exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $cars->image = $file_name;
        }

        $cars->model = $request->model;
        $cars->type = $request->type;
        $cars->price = $request->price;
        $cars->color = $request->color;
        $cars->person = $request->person;
        $cars->available = $request->available;
        $result = $cars->save();
        return redirect()->route('cars.index')
                        ->with('success','Car updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cars = Car::findOrFail($id);
        $cars->delete();
        return redirect()->route('cars.index')
                        ->with('success','Car deleted successfully');
    }
}

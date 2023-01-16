<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\Image;

class HomeController extends Controller
{
    public function index()
    {
        $img = !empty($this->getImage()) ? $this->getImage()->name : '';
        return view('home', ['countries' => $this->getCountries(), 'image' => $img]);
    }
    public function page1()
    {
        return view('page1', ['countries' => $this->getCountries()]);
    }
    public function page2()
    {
        return view('page2', ['countries' => $this->getCountries()]);
    }

    public function uploadImage(Request $request)
    {
        $image = $request->image;

        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time() . '.png';
        $path = public_path('upload/' . $image_name);

        // file_put_contents($path, $image);
        if (file_put_contents($path, $image)) {

            $image = new Image;

            $image->name = $image_name;
            $image->save();
            return response()->json(['status' => true]);
        }
        // return response()->json(['status' => true]);
    }

    public function getImage()
    {
        $img = Image::orderBy('created_at', 'DESC')->first();
        return $img;
    }

    public function getCountries()
    {
        $countries =  Country::get();
        return $countries;
    }

    public function changeCountryStatus(Request $request)
    {
        $id = $request->id;

        Country::where('status', 1)->update(['status' => 0]);
        Country::where('id', $id)->update(['status' => 1]);
        return response()->json(['status' => true]);
    }

    public function activeCountry()
    {
        $country = Country::where('status', 1)->get()->first();
        $code = $country->code;
        return redirect($code);
    }
}

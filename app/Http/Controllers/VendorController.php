<?php

namespace App\Http\Controllers;

use App\Models\VendorStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;

class VendorController extends Controller
{
    public function get()
    {
        $vendorStore = VendorStore::with('timings')->whereUserId(auth()->user()->id)->first();

        return response()->json(['success' => $vendorStore]);
    }

    public function update(Request $request)
    {
        $service = resolve(PostcodeService::class);

        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'number' => 'required',
            'postCode' => 'required',
        ]);
        $postCodeValidation = $service->validate($request->postCode);
        if(!$postCodeValidation){
            return response()->json(['errors' => 'Please enter correct post code.'], 402);
        }
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 402);
        }
        $location = $service->getPostcode($request->postCode);
        $vendorStore = VendorStore::updateOrCreate([
            'user_id' => auth()->user()->id,
        ],
            [
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'longitude' => $location->longitude,
                'latitude' => $location->latitude,
                'number' => $request->number,
                'post_code' => $request->postCode,
            ]);

        for ($i = 0; $i <= 6; $i++) {
            if($i == 0){
                $weekDay = 'Monday';
            }
            if($i == 1){
                $weekDay = 'Tuesday';
            }
            if($i == 2){
                $weekDay = 'Wednesday';
            }
            if($i == 3){
                $weekDay = 'Thursday';
            }
            if($i == 4){
                $weekDay = 'Friday';
            }
            if($i == 5){
                $weekDay = 'Saturday';
            }
            if($i == 6){
                $weekDay = 'Sunday';
            }
            $vendorStore->timings()->updateOrCreate(['vendor_store_id' => $vendorStore->id, 'weekday' => $weekDay],[
                'vendor_store_id' => $vendorStore->id,
                'weekday' => $weekDay,
                'start_hour' => (array_key_exists($i, $request->timings) && $request->timings[$i] != null) ? $request->timings[$i][0]['hours'] . ':'. $request->timings[$i][0]['minutes'] . ':'. $request->timings[$i][0]['seconds'] : null,
                'end_hour' => (array_key_exists($i, $request->timings)) ? $request->timings[$i][1]['hours'] . ':'. $request->timings[$i][1]['minutes'] . ':'. $request->timings[$i][1]['seconds'] : null,
                'status' => (array_key_exists($i, $request->shopClosed) && $request->shopClosed[$i] == true) ? 'closed' : 'open'
            ]);
        }

        return inertia('Profile/Edit', ['success' => 'Store information saved successfully.']);
    }
}

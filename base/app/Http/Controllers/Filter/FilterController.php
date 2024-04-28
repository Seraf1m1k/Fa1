<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Models\Filter\City;
use App\Models\Filter\Company;
use App\Models\Filter\Company_service;
use App\Models\Filter\Service;
use App\Models\Filter\For_user;
use App\Models\Filter\Tag;
use App\Models\Filter\Event;
use App\Models\Filter\Service_tag;
use App\Models\Filter\Service_event;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Params
        $city = $request->input('city');
        $status = $request->input('status');
        $category = $request->input('category');
        $event = $request->input('event');
        $search = $request->input('search');


        $flagStat = 0;
        $categories = null;

//
//        Check city
//
        if ($city == '')
        {
            $cities = City::all();
            return response()->json([
                'cities' => $cities,
            ]);
        }
        elseif ($city == '0')
        {
            //Вернуться
            $cities = 'all';
        }
        else
        {
            $cityId = City::where('name', $city)->value('id');

            if (!$cityId) {
                $cityLen = iconv_strlen($city);
                for ($i = 1; $i <= $cityLen; $i++) {
                    $res = City::where('name', 'LIKE', $city . '%')->get();
                    if (count($res) > 0) {
                        $i = $cityLen;
                    }
                    $city = substr($city, 0, -1);
                }
                return response()->json([
                    'error' => 'Город не найден',
                    'data' => $res,
                ], 404);
            }
            if ($cityId) {
                $services = Service::whereIn('id', function ($query) use ($cityId) {
                    $query->select('service_id')
                        ->from('company_services')
                        ->whereIn('company_id', function ($subQuery) use ($cityId) {
                            $subQuery->select('id')
                                ->from('companies')
                                ->where('city_id', $cityId);
                        });
                })->get();

//                return response()->json([
//                    'data' => $services,
//                ]);
            }
        }
//
//        Check status
//
        if ($status == ''){
            $status = For_user::all();
            return response()->json([
                'status' => $status,
            ]);
        }
        elseif ($status == '0'){
            $status = 'all';
        }
        else
        {
            $statusId = For_user::where('name', $status)->value('id');

            if (!$statusId) {
                $statusLen = iconv_strlen($status);
                for ($i = 1; $i <= $statusLen; $i++) {
                    $res = For_user::where('name', 'LIKE', '%' . $status . '%')->get();
                    if (count($res) > 0) {
                        $i = $statusLen;
                    }
                    $status = substr($status, 0, -1);
                }
                return response()->json([
                    'error' => 'Статус не найден',
                    'data' => $res,
                ], 404);
            }
            if ($statusId == 3) {
                $statusId = '2';
            }
            $categories = Tag::where('for_user_id', $statusId)->get();
//            $firstTagsId = $categories->first()->id;
//            $lastTagsId = $categories->last()->id;
        }


//
//        Check categories
//
        if (!$categories) {
            $categories = Tag::select('id', 'name')
                ->distinct('name')
                ->get();
            $flagStat = 1;
            if ($category == '') {
                return response()->json([
                    'categories' => $categories,
                ]);
            }
        }
        if ($category == "") {
            return response()->json([
                'categories' => $categories,
            ]);
        }
        elseif ($category == '0') {
            $category = 'all';
        }
        else {
            if ($flagStat == 0){
                $categoryId = Tag::where('for_user_id', $statusId)
                    ->where('name', $category)->value('id');
                if (!$categoryId) {
                    $categoryLen = iconv_strlen($category);
                    for ($i = 0; $i <= $categoryLen; $i++) {
                        $res = Tag::where('name', 'LIKE', '%' . $category . '%')
                            ->where('for_user_id', $statusId)
                            ->get();
                        if (count($res) > 0) {
                            $i = $categoryLen;
                        }
                        $category = substr($status, 0, -1);
                    }
                    return response()->json([
                        'error' => 'Статус не найден',
                        'data' => $res,
                    ], 404);
                }
            }elseif ($flagStat == 1) {
                $categoryId = Tag::where('name', $category)->value('id');
                if (!$categoryId) {
                    $categoryLen = iconv_strlen($category);
                    for ($i = 1; $i <= $categoryLen; $i++) {
                        $res = Tag::where('name', 'LIKE', '%' . $category . '%')->get();
                        if (count($res) > 0) {
                            $i = $categoryLen;
                        }
                        $category = substr($status, 0, -1);
                    }
                    return response()->json([
                        'error' => 'Статус не найден',
                        'data' => $res,
                    ], 404);
                }
            }
            $service_tags = Service_tag::where('tag_id', $categoryId)->get();
            $serviceIds = $service_tags->pluck('id');
            //-
            $service_events_ids = Service_event::whereIn('service_id', $serviceIds)
                ->groupBy('event_id')
                ->selectRaw('MAX(id) as id, event_id, MAX(service_id) as service_id')
                ->pluck('event_id');

            if ($flagStat == 0){
                $events = Event::whereIn('id', $service_events_ids)
                    ->where('for_user_id', $statusId)
                    ->get();
                $result = $events;
            }
            else {
                $events = Event::select('id', 'name', 'for_user_id')
                    ->whereIn('id', $service_events_ids)
                    ->distinct('name')
                    ->get();
                $uniqueEvents = $events->unique('name');
                $result = $uniqueEvents;
            }
        }

//
//        проверка event
//
        if ($event == ''){
            return response()->json([
                'services_events' => $result,
            ]);
        }
        elseif ($event == '0'){
            $event = 'all';
        }
        else
        {
            if ($flagStat == 0){
                $eventId = Event::where('name', $event)
                    ->where('for_user_id', $statusId)
                    ->value('id');
            }
            else {
                $eventId = Event::where('name', $event)->value('id');
            }

            $eventLen = iconv_strlen($event);
            if ($eventId === null && $flagStat == 0) {
                for ($i = 1; $i <= $eventLen; $i++) {
                    $res = Event::where('name', 'LIKE', '%' . $event . '%')
                        ->where('for_user_id', $statusId)
                        ->get();
                    if (count($res) > 0) {
                        $i = $eventLen;
                    }
                    $event = substr($event, 0, -1);
                }
                return response()->json([
                    'error' => 'Статус не найден',
                    'data' => $res,
                ], 404);
            }
            elseif ($flagStat == 1) {
                for ($i = 1; $i <= $eventLen; $i++) {
                    $res = Event::where('name', 'LIKE', '%' . $event . '%')
                        ->where('for_user_id', '2')
                        ->get();
                    if (count($res) > 0) {
                        $i = $eventLen;
                    }
                    $event = substr($event, 0, -1);
                }
                return response()->json([
                    'error' => 'Статус не найден',
                    'data' => $res,
                ], 404);
            }

            $service_events= Service_event::where('event_id', $eventId)->get();
            $service_tags = Service_tag::where('tag_id', $categoryId)->get();
            $data = [];
            foreach ($service_events as $service_event){
                foreach ($service_tags as $service_tag){
                    if ($service_event['service_id'] == $service_tag['service_id']){
                        $data[] = $service_event['service_id'];
                    }
                }
            }
            $data2 = [];
            foreach ($data as $elem){
                $data2[] = Service::where('id', $elem)->value('service');
            }
            return response()->json([
                $data2
            ]);


        }

    }








    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

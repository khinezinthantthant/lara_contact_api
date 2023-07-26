<?php

namespace App\Http\Controllers;

use App\Models\SearchRecords;
use App\Http\Requests\StoreSearchRecordsRequest;
use App\Http\Requests\UpdateSearchRecordsRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SearchRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return "hello";
        $contacts = Contact::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;

                $builder->where("name", "like", "%" . $keyword . "%");
            });
        })->latest("id")->paginate(5)->withQueryString();;

        // return $contacts;

        $records = [];
        foreach($contacts as $contact){
            $records[] = [
                "keyword" => $contact->keyword,
                "user_id" => Auth::id(),
                "created_at" => now(),
                "updated_at" => now()
            ];
        }

        Contact::insert($records);

        // return ContactResource::collection($contacts);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSearchRecordsRequest $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(SearchRecords $searchRecords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SearchRecords $searchRecords)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSearchRecordsRequest $request, SearchRecords $searchRecords)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SearchRecords $searchRecords)
    {
        //
    }
}

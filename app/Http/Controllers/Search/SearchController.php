<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSearch;
use App\Http\Requests\RecentSearches;
use App\Http\Requests\Search;
use App\Models\OngoingProject;
use App\Models\Project;
use App\Models\Review;
use App\Models\ProjectRequest;
use App\Models\RecentSearch;
use App\Models\SavedCompany;use App\Models\SavedProject;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function company_search(Search $request)
    {

        $user_id = $request->user_id;
        $search_string = $request->search_string;
        $range = $request->range;
        $company_type = $request->company_type;
        $company_type_id = $company_type['id'];
        $company_type_services = $company_type['services'];
        // $services = $request->services;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $query = User::query();

        // Apply filters based on request parameters
        if ($search_string) {
            $query->where('name', 'like', '%' . $search_string . '%');
        }

        if ($company_type) {
            if ($company_type_id) {
                $query->orWhereJsonContains('company_type', $company_type_id);
            }
        }

        if ($company_type_services && is_array($company_type_services)) {
            $query->where(function ($q) use ($company_type_services) {
                foreach ($company_type_services as $type) {
                    $q->orWhereJsonContains('services', $type);
                }
            });
        }

        if ($range) {
            // lat long of requesting user
            $latitude = $user->lat;
            $longitude = $user->long;
            if (empty($latitude) || empty($longitude)) {
                return response()->json(
                    [
                        'message' => 'Please set your location before applying range filter',
                        'status' => false,
                        'data' => [],
                    ],
                    200
                );
            }
            $query->whereNotNull('lat')
                ->whereNotNull('long')
                ->select('*')
                ->whereRaw("(6371 * acos(cos(radians($latitude)) * cos(radians(`lat`)) * cos(radians(`long`) - radians($longitude)) + sin(radians($latitude)) * sin(radians(`lat`)))) <= ?", [$range]);
        }

        // Exclude the requesting user from the result
        $query->where('id', '!=', $user->id);

        // Ensure that only company users are included
        $query->where('user_type', 'company');

        $result = $query->with('company_type.services')->get();

        foreach ($result as $company) {

            // total projects count
            // get those projects  which company has completed working with other private user/company
            $completed_Projects = $this->totalCompletedProjects($company->id);
            $company['totalProjects'] = count($completed_Projects);

            // total reviews count
            $reviews = Review::where('company_id', $company->id)->get();
            $averageRating = round($reviews->avg('rating'), 1);
            $totalRating = $reviews->count();
            $company['avgRating'] = $averageRating;
            $company['totalRating'] = $totalRating;

            // get saved details
            $saved = SavedCompany::where([
                'user_id' => $user_id,
                'company_id' => $company['id'],
            ])->first();
            if ($saved) {
                $company['saved'] = 1;
            } else {
                $company['saved'] = 0;
            }
            $company['distance'] = '0';
        }

        return response()->json(
            [
                'message' => 'Search Results',
                'status' => true,
                'data' => $result,
            ],
            200
        );
    }

    public function project_search(Search $request)
    {

        $user_id = $request->user_id;
        $search_string = $request->search_string;
        $range = $request->range;
        $company_type = $request->company_type;
        $company_type_id = $company_type['id'];
        $company_type_services = $company_type['services'];
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $query = Project::query();

        // Apply filters based on request parameters
        if ($search_string) {
            $query->where('name', 'like', '%' . $search_string . '%');
        }

        if ($company_type) {
            if ($company_type_id) {
                $query->orWhereJsonContains('company_type', $company_type_id);
            }
        }

        if ($company_type_services && is_array($company_type_services)) {
            $query->where(function ($q) use ($company_type_services) {
                foreach ($company_type_services as $type) {
                    $q->orWhereJsonContains('services', $type);
                }
            });
        }

        if ($range) {
            // lat long of requesting user
            $latitude = $user->lat;
            $longitude = $user->long;
            if (empty($latitude) || empty($longitude)) {
                return response()->json(
                    [
                        'message' => 'Please set your location before applying range filter',
                        'status' => false,
                        'data' => [],
                    ],
                    200
                );
            }
            $query->whereNotNull('lat')
                ->whereNotNull('long')
                ->select('*')
                ->whereRaw("(6371 * acos(cos(radians($latitude)) * cos(radians(`lat`)) * cos(radians(`long`) - radians($longitude)) + sin(radians($latitude)) * sin(radians(`lat`)))) <= ?", [$range]);
        }

        // Exclude the requesting user from the result
        $query->where('user_id', '!=', $user->id);
        $query->where('status', '!=', 0);

        $result = $query->with('company_types.services')->get();
        foreach ($result as $d) {
            // save project detail
            $saved = SavedProject::where([
                'user_id' => $user_id,
                'project_id' => $d['id'],
            ])->first();
            if ($saved) {
                $d['saved'] = 1;
            } else {
                $d['saved'] = 0;
            }
            $d['request_status'] = ProjectRequest::where('project_id', $d['id'])
                ->where('status', 1)
                ->exists();
        }

        return response()->json(
            [
                'message' => 'Search Results',
                'status' => true,
                'data' => $result,
            ],
            200
        );
    }

    // recent searches

    public function recent_search(Request $request)
    {
        $user = User::find(request('user_id'));
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        $check = RecentSearch::where([
            'user_id' => request('user_id'),
            'search_id' => request('search_id'),
            'search_type' => request('search_type'),
        ])->first();
        if (!empty($check)) {
            $check->delete();
        }
        $data = request(['user_id', 'search_id', 'search_type']);
        $recent_searches = RecentSearch::create($data);

        $data = [
            'message' => 'search successfull',
            'status' => true,
        ];
        return response($data, 200);
    }

    // delete recent search result
    public function delete_recent_search(Request $request)
    {

        $check = RecentSearch::where([
            'user_id' => request('user_id'),
            'search_id' => request('search_id'),
            'search_type' => request('search_type'),
        ])->first();
        if (!empty($check)) {
            $check->delete();
        }
        $data = [
            'message' => 'Deleted successfully',
            'status' => true,
        ];
        return response($data, 200);
    }

    // delete search history

    public function delete_search_history(DeleteSearch $request)
    {
        $type = request('type');
        $user_id = request('user_id');

        if ($type == 1) {
            RecentSearch::where('user_id', $user_id)
                ->where('search_type', 'project')
                ->delete();
        }
        if ($type == 2) {
            RecentSearch::where('user_id', $user_id)
                ->where('search_type', 'company')
                ->delete();
        }
        $data = [
            'message' => 'Deleted successfully',
            'status' => true,
        ];
        return response($data, 200);
    }

    public function get_recent_search(RecentSearches $request)
    {
        $user_id = $request->user_id;
        $type = $request->type;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => [],
            ];

            return response()->json($data, 200);
        }

        if ($type == '1') {
            $get_searches = RecentSearch::where([
                'user_id' => $user_id,
                'search_type' => 'project',
            ])->orderBy('id', 'DESC')->pluck('search_id')->toArray();
            $results = Project::whereIn('id', $get_searches)->select('id', 'name')->get();
        } else {
            $get_searches = RecentSearch::where([
                'user_id' => $user_id,
                'search_type' => 'company',
            ])->orderBy('id', 'DESC')->pluck('search_id')->toArray();
            $results = User::whereIn('id', $get_searches)->select('id', 'name')->get();
        }

        if (!empty($results)) {
            $data = [
                'message' => 'searches data load successfully',
                'status' => true,
                'data' => $results,
            ];
            return response($data, 200);
        } else {
            $data = [
                'message' => 'No searches found',
                'status' => true,
                'data' => [],
            ];
            return response($data, 200);
        }
    }

    public function totalCompletedProjects($company_id)
    {
        $completed_projects = OngoingProject::where([
            'company_id' => $company_id,
        ])->pluck('project_id')->toArray();

        return $completed_projects;
    }
}

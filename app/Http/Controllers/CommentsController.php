<?php

namespace App\Http\Controllers;

use App\Actions;
use App\Comment;
use App\Events\ActionItemSubmitted;
use App\Events\CommentWasSubmitted;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function addActionItem(Request $request)
    {
	    $this->validate($request, [
		    'action' => 'required',
		    'due_on' => 'required',
	    ]);

        $request->request->add(['submitted_by' => Auth::user()->id]);
        $request->request->add(['action_status' => 'Open']);

        if(!$request->has('due_on')) {
            $date = Carbon::now()->addWeeks(4)->toDateString();
            $request->request->add(['due_on' => $date]);
        }

        $action = Actions::create($request->all());

        $json['submitted_by'] = Auth::User()->name;
        $json['created_at'] = $action->created_at->toFormattedDateString();
        $json['due_on'] = Carbon::parse($action->due_on)->toFormattedDateString();
        $json['action'] = $action->action;
        $json['status'] = 'Open';
        $json['id'] = $action->id;

        Event::fire(new ActionItemSubmitted($action));

        return $json;
    }

    public function closeActionItem($id)
    {
        if(Auth::User()->hasRole(['administrator', 'approver'])) {
            $json['status'] = 1;
            $json['text'] = "Action item closed";
            $json['title'] = 'Complete!';
            $json['id'] = $id;
            $json['closed'] = Carbon::now()->toFormattedDateString();

            Actions::where('id', $id)->update([
                'action_status' => 'Closed',
                'closed_on' => Carbon::now()->toDateString()
            ]);
        } else {
            $json['status'] = 0;
            $json['text'] = "You do not have the correct privileges";
            $json['title'] = 'Error!';
        }
        return $json;
    }

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 * @internal param Request $request
	 */
    public function create()
    {

    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
    public function store(Request $request)
    {
	    Comment::create([
		    'request_id' => $request->request_id,
		    'user_id' => Auth::User()->id,
		    'comment' => $request->comment
	    ]);

        $event = \App\Request::find($request->request_id);
        Event::fire(new CommentWasSubmitted($event));

	    //$json['success'] = 1;
	    //return json_encode($json);
	    return $request->request_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

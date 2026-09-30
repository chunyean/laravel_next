<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\DB; //link DB library
use function PHPSTORM_META\type;


class Task_Controller extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->todos
        );
    }

    public function index2(Request $request)
    {
        $user_id = $request->user()->empl_id;        
        $name = $request->user()->name;

        if($name === 'admin'){
            $result = DB::select("SELECT *, name as creator FROM todos LEFT JOIN db_empl ON empl_id = user_id");
        } else {
            $result = DB::select("SELECT *, ? as creator FROM todos WHERE todos.user_id = ?", [$name, $user_id]);
        }
        
        if(!$result){
            return response()->json([
                'No record found'
            ], 404);
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        
        $todo = $request->user()->todos()->create([
            'title' => $request->title,
            'completed' => false,
        ]);

        return response()->json($todo);
    }

    // public function store2(Request $request)
    // {
        
    //     $datetime = date('Y-m-d H:i:s', time());

    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //     ]);
        
    //     $todo = DB::insert("INSERT INTO todos (title, user_id, created_at, updated_at) VALUES (?, ?, ?, ?)", [$request->title, $request->user()->id, $datetime, $datetime]);

    //     if($todo) {
    //         return response()->json('New Todo has been created');
    //     } else {
    //         return response()->json('Fail to create');
    //     }
        
    // }

    public function show(Request $request, Todo $params)
    {

        if ($params->user_id != $request->user()->empl_id && $request->user()->name != 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json($params);
    }

    public function show2(Request $request, $params)
    {

        $result = DB::select("SELECT * FROM todos WHERE id = ?", [$params]);

        if($result[0]->user_id != $request->user()->empl_id && $request->user()->name != 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        if(!$result) {
            return response()->json([
                'message' => 'No todo found'
            ], 403);
        }

        return response()->json($result[0]);
    }

    public function update(Request $request, Todo $params)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // method 1
        // $params->update(['title' => $request->title]);

        //method 2
        $params->title = $request->title;
        $params->save();

        return response()->json($params);
    }

    public function update2(Request $request, $params)
    {
        $todos = DB::selectOne("SELECT title, user_id FROM todos WHERE id = ?", [$params]);

        if($todos->user_id != $request->user()->empl_id && $request->user()->name != 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
        
        if($request->title){
            $validated = $request->validate([
                'title' => 'required|string|max:255',
            ]);

            $result = DB::update("UPDATE todos SET title = ? WHERE id = ?", [$request->title, $params]);
        } else {
            $result = DB::update("UPDATE todos SET completed = 1 WHERE id = ?", [$params]);
        }

        if($result) {
            return response()->json('ID: '.$todos->title .' has been updated');
        } else {
            return response()->json('Fail to update');
        }
    }


    public function delete(Request $request, Todo $params)
    {

        if ($params->user_id != $request->user()->empl_id && $request->user()->name != 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $params->delete();

        return response()->json('Deleted');
    }

    public function delete2(Request $request, $params)
    {

        $result = DB::select("SELECT * FROM todos WHERE id = ?", [$params]);

        if(!$result) {
            return response()->json([
                'message' => 'ID: ' . $params .' Not Found'
            ], 404);
        }

        if ($result[0]->user_id != $request->user()->empl_id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        DB::delete("DELETE FROM todos WHERE id = ?", [$params]);

        return response()->json('Successful Deleted');
    }
n 
}

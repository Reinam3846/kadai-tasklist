<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            
            ];  
        
            return view('tasks.index', [
                'tasks' => $tasks,
           ]); 
        
          //
        } else {
          return view('welcome', $data);
        }
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:255',
            'content' => 'required|max:255',
             
        ]);
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
       
           $request->user()->tasks()->create([
        
         'content' => $request->content,
         'status'  => $request->status,
       
          
         ]);
       
        
        
       
        
     
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
    ]);//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);   //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
           
        ]);

        
        // idの値でタスクを検索して取得
     
        //$task = Task::findOrFail($request,$id);
        $task = Task::findOrFail($id);
        // タスクを更新
        /*
        $request->tasks()->update([
         'content' => $request->content,
         'status'  => $request->status,
       ]);    // トップページへリダイレクトさせる
       */
       $task->update([
         'content' => $request->content,
         'status'  => $request->status,
       ]);  
    
         return redirect('/');
    }

     /**
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // idの値で投稿を検索して取得
        $task = \App\Task::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        
             if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        // トップページへリダイレクトさせる
         return redirect('/');
    }
}

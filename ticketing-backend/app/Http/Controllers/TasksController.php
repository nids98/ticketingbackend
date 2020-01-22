<?php

namespace App\Http\Controllers;
use App\Tasks;
use App\Categories;
use App\Employees;
use App\UsersAndTasks;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{

    public function updateStatus(Request $request,$task_idd) {

        DB::table('tasks')
            ->where ('task_id',$task_idd)
            ->update(['status' => 'completed']);

        DB::table('tech_id_totask_ids')
            ->where ('task_id',$task_idd)
            ->update(['status' => 'completed']);

        return "Success";
    }


    public function getList(Request $request,$tech_idd) {

        $array = DB::table('tech_id_totask_ids')->select('task_id', 'status')
            ->where('tech_id', '=', $tech_idd)
            ->get();


        return response()->json($array);
    }


    public function getTaskDesc(Request $request,$tech_id,$task_idd) {

        $info = DB::table('tasks')->select('desc', 'status')
            ->where('task_id', '=', $task_idd)
            ->get();

        $cat_idd = DB::table('tasks')->select('cat_id')
            ->where('task_id', '=', $task_idd)
            ->get();

        $cat_name_obj= DB::table('cat_id_tocat_names')->select('cat_name')
            ->where('cat_id', '=', strval($cat_idd[0]->cat_id) )
            ->get();

        $cat_name= strval($cat_name_obj[0]->cat_name);

        $json = json_decode( $info );
        $json[0]->cat_name= $cat_name;

        return response()->json($json);
    }


    public function createTask(Request $request) {
        // Create a new task
        $task = new Tasks();

        $task->category_name = $request->input("category_name");
        $task->desc = $request->input("desc");
        $task->status = "pending";

        // Save task
        $task->save();

        //Get category_id from category
        $category_id = Categories::where('category_name', 'LIKE', '%'.$request->input("category_name").'%')->get();
        $category_id = $category_id[0]->category_id;

        //Get all employees of this category_id
        $all_eid = Employees::where('category_id', $category_id)->get();

        //Get number of tasks of each employee
        $emptask_count =  DB::table('users_and_tasks')
            ->select(DB::raw('emp_id, count(*) as numTasks'))
            ->groupBy('emp_id')
            ->where('status', "pending")
            ->get();


        //Get the employee id who has the minimum number of tasks
        $minTask = 100000000;
        $minTaskEid = -1;
        foreach ($emptask_count as $item) {
            if($item->numTasks < $minTask) {
                $minTask = $item->numTasks;
                $minTaskEid = $item->emp_id;
            }
        }

        //Get auto increment id(current task id)
        $taskId = DB::table('tasks')->max('task_id');

        //Insert into users_and_tasks table
        $new_user_task_pair = new UsersAndTasks();

        $new_user_task_pair->emp_id = $minTaskEid;
        $new_user_task_pair->task_id = $taskId;
        $new_user_task_pair->status = "pending";

        $new_user_task_pair->save();

        return $task;
        // return response()->json($task);
    }
}

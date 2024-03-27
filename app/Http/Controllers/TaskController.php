<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator facade

// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Url;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }


    // public function getImageURL(Request $request, $filename)
    // { 
    // if (Storage::disk('local')->exists($filename)) {
    //     $url = Storage::disk('local')->url($filename);

    //     $filePath = Storage::disk('local')->path($filename);

    //     // Prepare the file for download (optional, e.g., set headers)
    //     return response()->download($filePath);

    //     // // Generate a signed URL with a reasonable expiration time (e.g., 5 minutes)
    //     //     $url = URL::temporarySignedRoute(
    //     //         'download-file', // Route name for downloading
    //     //         now()->addMinutes(5), // Expiration time
    //     //         ['filename' => $filename]
    //     //     );
    //     // return response()->json(['url' => $url]);
    // } else {
    //     // Handle cases where the image doesn't exist
    //     return response()->json(['error' => 'Image not found'], 404);
    // }
    // }

    // public function downloadFile(Request $request, $filename)
    // {
    //     // Check if the file exists using Storage::disk('local')->exists($filename)
    //     if (!Storage::disk('local')->exists($filename)) {
    //         return response()->json(['error' => 'File not found'], 404);
    //     }

    //     // Retrieve the file path using Storage::disk('local')->path($filename)
    //     $filePath = Storage::disk('local')->path($filename);

    //     // Prepare the file for download (optional, e.g., set headers)
    //     return response()->download($filePath);
    // }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string',
            'status' => 'required|string',
          ]);

          if ($validatedData->fails()) {
            // Handle validation errors
            return back()->withErrors($validatedData);
        }

        //   $taskAttributes = [
        //     'title' => $validatedData['title'],
        //     'status' => $validatedData['status'],
        //   ];
          if ($request->hasFile('attachment')) {
            $filename = $request->file('attachment')->store('attachments'); // Store the file
            $taskAttributes['attachment'] = $filename;
          }
        
          $taskAttributes = $validatedData->validated(); // Access validated data as an array
        //   $task->save();
          $task = Task::create($taskAttributes);

          // Flash a success message to the session for display on the next request
        $request->session()->flash('success', 'File uploaded successfully!');

        // Clear the form data (optional, consider user experience)
        $request->session()->forget('oldInput'); // Clears old form input from session

        //   return redirect('/tasks');
          
        //$task = Task::create($request->all());
        // return response()->json($task, 201);

        return response()->json([
            'message' => 'Task Created successfully',
            'task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        return response()->json($task);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {    print_r("hello edit");
        $validatedData = $request->validate([
            'title' => 'required|string',
            'status' => 'required|string',
          ]);
        
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->update($request->all());
        // return response()->json($task);

        // Return success response with updated task
    return response()->json([
        'message' => 'Task updated successfully',
        'task' => $task
    ], 200);
    }
    public function update(Request $request, $id)
    { 
        $task->update($request->all());
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $taskresult
        ], 200);
    }
    // public function update(Request $request, $id)
    // {    
    //     $validatedData = Validator::make($request->all(), [
    //         'title' => 'required|string',
    //         'status' => 'required|string',
    //       ]);

    //       if ($validatedData->fails()) {
    //         // Handle validation errors
    //         return back()->withErrors($validatedData);
    //     }          
        
    //     // $taskAttributes = [
    //     //     'title' => $validatedData['title'],
    //     //     'status' => $validatedData['status'],
    //     //   ];

    //     if ($request->hasFile('attachment')) {
    //         $filename = $request->file('attachment')->store('attachments'); // Store the file
    //         $taskAttributes['attachment'] = $filename;
    //       }

    //       $taskAttributes = $validatedData->validated(); // Access validated data as an array

    //     $task = Task::find($id);
    //     print_r($task);
    //     if (!$task) {
    //         return response()->json(['error' => 'Task not found'], 404);
    //     }

    //     // Update the model with validated data
    //    //$task->update($taskAttributes);

    //   $taskresult = $task->update($taskAttributes->all());
    //     // $task->update($request->all());
    //     // return response()->json($task);

    //     // Return success response with updated task
    // return response()->json([
    //     'message' => 'Task updated successfully',
    //     'task' => $taskresult
    // ], 200);
    // }

    /**
     * Remove the specified resource from storage.
     *
    * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\projects;
use App\Models\tasks;
use App\Models\User;
use App\Models\posts;
use App\Models\units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class adminController extends Controller
{
    // **********************User******************************* //
    public function addUser(Request $request)
    {
        try {
            $name = $request->input("name");
            $email = $request->input("email");
            $role = $request->input("role");
            $mdp = $request->input("password");
            $confirm = $request->input("confirm");
            $position = $request->input('position');
            $salary = $request->input('salary');
            $hash = Hash::make($mdp);
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = $hash;
            $user->role = $role;
            $user->position = $position;
            $user->salary = $salary;
            $user->save();
            return Redirect("/users?succAdd") //->with(["success" => "compte crée avec succès"])
            ;
        } catch (\Throwable $th) {
            return Redirect()->back()->with(['msg' => $th->getMessage()]);
        }
    }
    function VerifierExistance()
    {
        if (request()->has("query")) {
            $query = request()->get("query");

            if ($query == "email") {
                $val = request()->get("em");
                return User::where("email", "LIKE", "$val")->first()->count();
            }
        }
    }
    public function deleteUser($id)
    {
        try {
            $user = User::where("id", $id)->first();
            $user->delete();
            return response()->json(['status' => 'User deleted successfully']);
        } catch (\Throwable $th) {
            return Response($th->getMessage(), 500);
        }
    }
    public function editUser(Request $request)
    {
        try {
            $name = $request->input("name");
            $email = $request->input("email");
            $role = $request->input("role");
            $mdp = $request->input("password");
            $position = $request->input('position');
            $salary = $request->input('salary');
            $hash = Hash::make($mdp);
            $idU = $request->input("idU");
            $U = User::where("email", $email)->where("id", "!=", $idU)->first();
            if ($U) {
                return Redirect("/users?EmailExist");
            }
            $user = User::where("id", $idU)->first();
            if ($mdp != "") {
                $newPass = Hash::make($mdp);
            } else {
                $newPass = $user->password;
            }
            $U = User::where("id", $idU)->first();
            $U->name = $name;
            $U->email = $email;
            $U->role = $role;
            $U->position = $position;
            $U->salary = $salary;
            $U->password = $newPass;
            $U->save();
            return Redirect("/users?updateSucc");
        } catch (\Throwable $th) {
            return Redirect()->back()->with(['msg' => $th->getMessage()]);
        }
    }
    // *************************Project**************************** //

  
    public function show($id)
    {
        $project = projects::find($id);

        if (!$project) {
            return redirect()->back()->with('error', 'Project not found');
        }

        return view('projectShow', compact('project'));
    }
    public function deleteProject($id)
    {
        try {
            $project = projects::where("id", $id)->first();
            $project->delete();
            return response()->json(['status' => 'project deleted successfully']);
        } catch (\Throwable $th) {
            return Response($th->getMessage(), 500);
        }
    }
    // **************************Task*************************** //


    public function addTask(Request $request)
    {
        try {
            $name = $request->input("name");
            $minutes = $request->input('minutes');
            $task = new tasks();
            $task->name = $name;
            $task->minutes = $minutes;
            $task->save();
            return Redirect("/tasks?succAdd");
        } catch (\Throwable $th) {
            return Redirect()->back()->with(['msg' => $th->getMessage()]);
        }
    }
    public function deleteTask($id)
    {
        try {
            $task = tasks::where("id", $id)->first();
            $task->delete();
            return response()->json(['status' => 'Task deleted successfully']);
        } catch (\Throwable $th) {
            return Response($th->getMessage(), 500);
        }
    }
    // *****************Products******************************//
    public function addProduct(Request $request)
    {
        try {
            $product = new products();
            $barcode = $request->input('barcode');
            $product_name = $request->input('name');
            $product_quantity = $request->input('quantity');
            $product_price = $request->input('price');
            $product_supplier = $request->input('supplier');

            $unit=$request->input('unit');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();

                $image_name = time() . '.' . $extension;
                $image->move('uploads/imgs/', $image_name);
                $product->image = $image_name;
            }

            $product->barcode = $barcode;
            $product->product_name = $product_name;
            $product->product_quantity = $product_quantity;
            $product->unit=$unit;
            $product->product_price = $product_price;
            $product->supplier=$product_supplier;
            if ($request->input('quantity') != 0) {
                $product->isAvailable = 'yes';
            } else {
                $product->isAvailable = 'no';
            }
           
            $product->save();
          
            return Redirect("/products?succAdd");
        } catch (\Throwable $th) {
            return Redirect()->back()->with(['msg' => $th->getMessage()]);
        }
    }
    public function deleteProduct($id)
    {
        try {
            $product = products::where("id", $id)->first();
            $product->delete();
            return response()->json(['status' => 'product deleted successfully']);
        } catch (\Throwable $th) {
            return Response($th->getMessage(), 500);
        }
    }
    public function getProductImage($id)
{
    $product = products::where("id", $id)->first();
    $imagePath = public_path('imgs/'.$product->image);
    $relativePath = str_replace(public_path(), "", $imagePath);
    $relativePath = str_replace("\\", "/", $relativePath);
    $relativePath = ltrim($relativePath, '/');
    $relativePath = "uploads/" . $relativePath;

    return response()->json($relativePath);
}
public function checkStock($productId, $quantity) {
    $product = products::find($productId);
    if ($product && $quantity <= $product->product_quantity) {
        return response()->json(['available' => true]);
    } else if ($product->product_quantity!=0) {
        return response()->json(['available' => false, 'message' => 'Quantity should be at maximum ' . $product->product_quantity]);
    }
    else{
        return response()->json(['available' => false, 'message' => 'Product is out of stock' ]);

    }
}
public function addProject(Request $request)
{
    $project = new projects();
    $project->name = $request->input('projectName');
    $project->tasks =json_encode( $request->input('totalMinutes'));
    $project->start_date = $request->input('startDate');
    $project->delivery_date = $request->input('deliveryDate');
    $project->status="In Progress";
    // Store the products in the 'products' column as a JSON string
    $products = $request->input('products');
    $project->products = json_encode($products);
    foreach ($products as $product) {
        $productId = $product['productId'];
        $quantity = $product['quantity'];
        $product = products::find($productId);
        $product->product_quantity -= $quantity;
        if($product->product_quantity==0){
            $product->isAvailable="no";
        }
        $product->save();
    }
    $project->save();

    return response()->json(['message' => 'Project saved successfully.']);
}
public function CompleteP(Request $request)
{
    $idProject = $request->route('id');
    $project = projects::find($idProject);

    if (!$project) {
        return redirect('/')->with('error', 'Invalid project ID');
    }

    $project->status = "Completed";
    $project->save();

    return redirect('/')->with('success', 'Project marked as completed');
}

// *********************POSTS************************* //

public function addPost(Request $request)
{
    try {
        $name = $request->input("name");
        $task = $request->input('task');
        $post = new posts();
        $post->name = $name;
        $post->task_id = $task;
        $post->save();
        return Redirect("/posts?succAdd");
    } catch (\Throwable $th) {
        return Redirect()->back()->with(['msg' => $th->getMessage()]);
    }
}
public function deletePost($id)
{
    try {
        $post = posts::where("id", $id)->first();
        $post->delete();
        return response()->json(['status' => 'Task deleted successfully']);
    } catch (\Throwable $th) {
        return Response($th->getMessage(), 500);
    }
}
public function searchProjects(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $projects = projects::whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('delivery_date', [$startDate, $endDate])
                ->get();

    return view('project-list', ['projects' => $projects,'startDate' => $startDate,
    'endDate' => $endDate,]);
}

public function deleteunit($id)
{
    try {
        $post = units::where("id", $id)->first();
        $post->delete();
        return response()->json(['status' => 'Unit deleted successfully']);
    } catch (\Throwable $th) {
        return Response($th->getMessage(), 500);
    }
}
public function addunit(Request $request)
    {
        try {
            $name = $request->input("name");
            $unit = new units();
            $unit->name = $name;
            $unit->save();
            return Redirect("/units?succAdd");
        } catch (\Throwable $th) {
            return Redirect()->back()->with(['msg' => $th->getMessage()]);
        }
    }
}

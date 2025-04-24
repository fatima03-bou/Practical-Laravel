<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Http\Response;

class OrderStatusController extends Controller
{
   
    public function index()
    {
       
        $orders = Order::with('items')->where('user_id', auth()->id())->get();

        return response()->json($orders, Response::HTTP_OK);
    }

    
    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'total' => 'required|integer',
            
        ]);

      
        $order = Order::create([
            'total'   => $validatedData['total'],
            'user_id' => auth()->id(),
            'status'  => 'Packed' 
        ]);

        return response()->json($order, Response::HTTP_CREATED);
    }

   
    public function show($id)
    {
        
        $order = Order::with('items')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($order, Response::HTTP_OK);
    }


    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], Response::HTTP_NOT_FOUND);
        }

       
        $validatedData = $request->validate([
            'total' => 'sometimes|required|integer',
            
        ]);

        $order->update($validatedData);

        return response()->json($order, Response::HTTP_OK);
    }

 
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $order->delete();

        return response()->json(['message' => 'Commande supprimée avec succès'], Response::HTTP_NO_CONTENT);
    }

 
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], Response::HTTP_NOT_FOUND);
        }


        $validatedData = $request->validate([
            'status' => 'required|in:Packed,Shipped,In Transit,Received,Returned,Closed'
        ]);

        $order->update(['status' => $validatedData['status']]);

        return response()->json($order, Response::HTTP_OK);
    }
}

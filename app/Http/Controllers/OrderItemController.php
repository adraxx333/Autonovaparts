<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $orderItem = OrderItem::create([
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
                'order_id' => $request->order_id,
                'part_id' => $request->part_id,
                'part_name' => $request->part_name,
                'part_code' => $request->part_code,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'subtotal' => $request->price * $request->quantity,
            ]);

            // Actualizar el stock de la parte
            $part = Part::find($request->part_id);
            if ($part) {
                $newStock = $part->stock - $request->quantity;
                $part->stock = max(0, $newStock);

                // Si el stock llega a 0, desactivar la parte
                if ($part->stock <= 0) {
                    $part->is_active = false;
                }

                $part->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Item de pedido creado exitosamente',
                'order_item' => $orderItem
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear el item de pedido',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getByOrder($orderId)
    {
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        return response()->json($orderItems);
    }
}

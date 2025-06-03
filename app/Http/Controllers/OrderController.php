<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with(['items.part'])
                ->where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($order) {
                    return [
                        'uuid' => $order->uuid,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'total' => $order->total_amount,
                        'items_count' => $order->items->count(),
                        'created_at' => $order->created_at,
                        'shipping_address' => $order->shipping_address,
                        'items' => $order->items->map(function ($item) {
                            return [
                                'id' => $item->uuid,
                                'part' => [
                                    'name' => $item->part_name,
                                    'code' => $item->part_code
                                ],
                                'quantity' => $item->quantity,
                                'price' => $item->price,
                                'subtotal' => $item->subtotal
                            ];
                        })
                    ];
                });

            return response()->json($orders);
        } catch (\Exception $e) {
            Log::error('Error al obtener órdenes:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error al obtener las órdenes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Datos recibidos en OrderController@store:', $request->all());

            // Verificar si las partes existen
            foreach ($request->items as $item) {
                $part = Part::where('id', $item['part_id'])->first();
                Log::info('Verificando parte:', [
                    'part_id' => $item['part_id'],
                    'existe' => $part ? 'sí' : 'no',
                    'part' => $part
                ]);

                if (!$part) {
                    throw new \Exception("La parte con ID {$item['part_id']} no existe");
                }
            }

            // Validar los datos de entrada
            $validated = $request->validate([
                'total_amount' => 'required|numeric|min:0',
                'items' => 'required|array|min:1',
                'items.*.part_id' => ['required', 'string', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i'],
                'items.*.part_name' => 'required|string',
                'items.*.part_code' => 'required|string',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.quantity' => 'required|integer|min:1',
                'shipping_info' => 'required|array',
                'shipping_info.email' => 'required|email',
                'shipping_info.phone' => 'required|string|min:9',
                'shipping_info.name' => 'required|string',
                'shipping_info.address' => 'required|string',
                'shipping_info.city' => 'required|string',
                'shipping_info.postalCode' => 'required|string|size:5'
            ]);

            Log::info('Datos validados:', $validated);

            DB::beginTransaction();

            // Crear la orden
            $order = new Order();
            $order->uuid = (string) Str::uuid();
            $order->user_id = Auth::user()->id;
            $order->order_number = $order->generateOrderNumber();
            $order->total_amount = $request->total_amount;
            $order->status = 'pending';
            $order->shipping_email = $request->shipping_info['email'];
            $order->shipping_phone = $request->shipping_info['phone'];
            $order->shipping_name = $request->shipping_info['name'];
            $order->shipping_address = $request->shipping_info['address'];
            $order->shipping_city = $request->shipping_info['city'];
            $order->shipping_postal_code = $request->shipping_info['postalCode'];
            $order->save();

            Log::info('Orden creada:', ['order' => $order->toArray()]);

            // Crear los items de la orden
            foreach ($request->items as $item) {
                $part = Part::where('id', $item['part_id'])->first();
                if (!$part) {
                    throw new \Exception("La parte con ID {$item['part_id']} no existe");
                }

                $orderItem = new OrderItem();
                $orderItem->uuid = (string) Str::uuid();
                $orderItem->order_id = $order->id;
                $orderItem->part_id = $item['part_id'];
                $orderItem->part_name = $item['part_name'];
                $orderItem->part_code = $item['part_code'];
                $orderItem->price = $item['price'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->subtotal = $item['price'] * $item['quantity'];
                $orderItem->save();

                Log::info('Item creado:', ['orderItem' => $orderItem->toArray()]);

                // Actualizar el stock
                $part->stock -= $item['quantity'];
                if ($part->stock <= 0) {
                    $part->is_active = false;
                }
                $part->save();
                Log::info('Stock actualizado:', ['part' => $part->toArray()]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Orden creada exitosamente',
                'order' => $order->load('items')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la orden:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Error al crear la orden',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Estado de la orden actualizado exitosamente',
            'order' => $order
        ]);
    }
}

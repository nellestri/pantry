<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\FoodTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FoodItemController extends Controller
{
    public function index()
    {
        $foodItems = FoodItem::with('transactions')
                            ->orderByRaw('CASE 
                                WHEN expiry_date IS NULL THEN 3
                                WHEN expiry_date < NOW() THEN 1 
                                WHEN expiry_date <= DATE_ADD(NOW(), INTERVAL 7 DAY) THEN 2
                                ELSE 3
                            END')
                            ->orderBy('expiry_date')
                            ->get();

        // Get statistics
        $stats = [
            'total' => $foodItems->count(),
            'expired' => $foodItems->filter(fn($item) => $item->isExpired())->count(),
            'expiring_soon' => $foodItems->filter(fn($item) => $item->expiresSoon())->count(),
            'low_stock' => $foodItems->filter(fn($item) => $item->getQuantityPercentage() < 25)->count()
        ];

        return view('food-items.index', compact('foodItems', 'stats'));
    }

    public function create()
    {
        return view('food-items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'expiry_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000'
        ]);

        $foodItem = FoodItem::create([
            'name' => $request->name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'expiry_date' => $request->expiry_date,
            'notes' => $request->notes,
            'original_quantity' => $request->quantity
        ]);

        // Create transaction record
        FoodTransaction::create([
            'food_item_id' => $foodItem->id,
            'type' => 'added',
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'notes' => 'Initial stock added'
        ]);

        return redirect()->route('food-items.index')
                         ->with('success', 'Food item added successfully!');
    }

    public function show(FoodItem $foodItem)
    {
        $foodItem->load('transactions');
        return view('food-items.show', compact('foodItem'));
    }

    public function edit(FoodItem $foodItem)
    {
        return view('food-items.edit', compact('foodItem'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'expiry_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000'
        ]);

        $oldQuantity = $foodItem->quantity;
        $newQuantity = $request->quantity;

        $foodItem->update($request->all());

        // Create transaction if quantity changed
        if ($oldQuantity != $newQuantity) {
            $transactionType = $newQuantity > $oldQuantity ? 'added' : 'consumed';
            $quantityDiff = abs($newQuantity - $oldQuantity);

            FoodTransaction::create([
                'food_item_id' => $foodItem->id,
                'type' => $transactionType,
                'quantity' => $quantityDiff,
                'unit' => $request->unit,
                'notes' => 'Quantity updated via edit'
            ]);
        }

        return redirect()->route('food-items.index')
                         ->with('success', 'Food item updated successfully!');
    }

    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();
        return redirect()->route('food-items.index')
                         ->with('success', 'Food item deleted successfully!');
    }

    public function consume(Request $request, FoodItem $foodItem)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.1|max:' . $foodItem->quantity,
            'notes' => 'nullable|string|max:500'
        ]);

        $foodItem->quantity -= $request->quantity;
        $foodItem->save();

        FoodTransaction::create([
            'food_item_id' => $foodItem->id,
            'type' => 'consumed',
            'quantity' => $request->quantity,
            'unit' => $foodItem->unit,
            'notes' => $request->notes ?? 'Item consumed'
        ]);

        return redirect()->route('food-items.index')
                         ->with('success', 'Consumption recorded successfully!');
    }

    public function transactions()
    {
        $transactions = FoodTransaction::with('foodItem')
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(20);

        return view('food-items.transactions', compact('transactions'));
    }
}
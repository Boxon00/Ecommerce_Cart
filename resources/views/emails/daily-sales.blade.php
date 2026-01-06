<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f97316; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background-color: #f9f9f9; padding: 30px; border-radius: 0 0 5px 5px; }
        .product-info { background-color: white; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .warning { color: #f97316; font-weight: bold; font-size: 18px; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Low Stock Alert</h1>
        </div>
        <div class="content">
            <p>Hello Admin,</p>

            <p class="warning">A product is running low on stock!</p>

            <div class="product-info">
                <h2>{{ $product->name }}</h2>
                <p><strong>Current Stock:</strong> {{ $product->stock_quantity }} units</p>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                @if($product->description)
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                @endif
            </div>

            <p>Please consider restocking this product soon to avoid running out of stock.</p>

            <p>Best regards,<br>E-commerce System</p>
        </div>
        <div class="footer">
            <p>This is an automated notification from your E-commerce Shopping Cart system.</p>
        </div>
    </div>
</body>
</html>

<!-- ========================================================================== -->
<!-- FAJL: resources/views/emails/daily-sales.blade.php -->
<!-- ========================================================================== -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4f46e5; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background-color: #f9f9f9; padding: 30px; border-radius: 0 0 5px 5px; }
        .summary { background-color: white; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .summary-item { display: flex; justify-content: space-between; margin: 10px 0; padding: 10px 0; border-bottom: 1px solid #eee; }
        table { width: 100%; background-color: white; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #4f46e5; color: white; }
        .total-row { font-weight: bold; background-color: #f3f4f6; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Daily Sales Report</h1>
            <p>{{ $date->format('F d, Y') }}</p>
        </div>
        <div class="content">
            <p>Hello Admin,</p>

            <p>Here is the sales report for today:</p>

            <div class="summary">
                <h3>Summary</h3>
                <div class="summary-item">
                    <span>Total Orders:</span>
                    <strong>{{ $orders->count() }}</strong>
                </div>
                <div class="summary-item">
                    <span>Total Revenue:</span>
                    <strong>${{ number_format($orders->sum('total_amount'), 2) }}</strong>
                </div>
                <div class="summary-item">
                    <span>Total Items Sold:</span>
                    <strong>{{ $orders->flatMap->items->sum('quantity') }}</strong>
                </div>
            </div>

            <h3>Order Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Amount</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->items->count() }} items</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ $order->created_at->format('h:i A') }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3">TOTAL</td>
                        <td>${{ number_format($orders->sum('total_amount'), 2) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <h3>Products Sold Today</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity Sold</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $productSales = $orders->flatMap->items->groupBy('product_name')->map(function($items) {
                            return [
                                'quantity' => $items->sum('quantity'),
                                'revenue' => $items->sum(function($item) {
                                    return $item->quantity * $item->price;
                                })
                            ];
                        });
                    @endphp
                    @foreach($productSales as $productName => $data)
                        <tr>
                            <td>{{ $productName }}</td>
                            <td>{{ $data['quantity'] }}</td>
                            <td>${{ number_format($data['revenue'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p>Best regards,<br>E-commerce System</p>
        </div>
        <div class="footer">
            <p>This is an automated daily report from your E-commerce Shopping Cart system.</p>
        </div>
    </div>
</body>
</html>

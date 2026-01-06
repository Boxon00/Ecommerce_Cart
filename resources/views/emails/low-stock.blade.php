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

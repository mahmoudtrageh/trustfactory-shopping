<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f44336;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .alert-box {
            background-color: #fff;
            border-left: 4px solid #f44336;
            padding: 15px;
            margin: 20px 0;
        }
        .product-details {
            margin: 15px 0;
        }
        .product-details strong {
            display: inline-block;
            width: 150px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>⚠️ Low Stock Alert</h1>
    </div>
    <div class="content">
        <p>Hello Admin,</p>
        
        <p>This is an automated notification to inform you that a product in your inventory is running low on stock.</p>
        
        <div class="alert-box">
            <h2 style="margin-top: 0; color: #f44336;">Stock Alert</h2>
            <div class="product-details">
                <p><strong>Product ID:</strong> #{{ $product->id }}</p>
                <p><strong>Product Name:</strong> {{ $product->name }}</p>
                <p><strong>Current Stock:</strong> <span style="color: #f44336; font-weight: bold;">{{ $product->stock_quantity }} units</span></p>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            </div>
        </div>
        
        <p><strong>Action Required:</strong> Please restock this product as soon as possible to avoid running out of inventory.</p>
        
        <p>Thank you,<br>{{ config('app.name') }} System</p>
    </div>
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>

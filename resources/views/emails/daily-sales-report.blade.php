<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header .date {
            margin-top: 5px;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .summary-cards {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .summary-card {
            display: table-cell;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            border: 1px solid #e0e0e0;
            width: 50%;
        }
        .summary-card:first-child {
            border-right: none;
            border-radius: 5px 0 0 5px;
        }
        .summary-card:last-child {
            border-radius: 0 5px 5px 0;
        }
        .summary-card .label {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .summary-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin: 30px 0 15px 0;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin: 15px 0;
            border-radius: 5px;
            overflow: hidden;
        }
        .products-table th {
            background-color: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }
        .products-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .products-table tr:last-child td {
            border-bottom: none;
        }
        .products-table tr:hover {
            background-color: #f5f5f5;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Daily Sales Report</h1>
        <div class="date">{{ $date->format('l, F j, Y') }}</div>
    </div>
    
    <div class="content">
        <p>Hello Admin,</p>
        <p>Here is your daily sales summary for {{ $date->format('M d, Y') }}:</p>
        
        <div class="summary-cards">
            <div class="summary-card">
                <div class="label">Total Orders</div>
                <div class="value">{{ $totalOrders }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Revenue</div>
                <div class="value">${{ number_format($totalRevenue, 2) }}</div>
            </div>
        </div>
        
        @if($productsSold->isNotEmpty())
            <h2 class="section-title">Products Sold</h2>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th style="text-align: center;">Quantity Sold</th>
                        <th style="text-align: right;">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productsSold as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td style="text-align: center;"><strong>{{ $product->total_quantity }}</strong></td>
                            <td style="text-align: right;">${{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>No orders were placed on this day.</p>
            </div>
        @endif
        
        <p style="margin-top: 30px;">Thank you,<br><strong>{{ config('app.name') }} System</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated daily report generated at {{ now()->format('h:i A') }}.</p>
        <p>Please do not reply to this email.</p>
    </div>
</body>
</html>

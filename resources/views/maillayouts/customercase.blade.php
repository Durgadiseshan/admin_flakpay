<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test View</title>
</head>
<body>
    Hi {{$htmldata["name"]}},<br>
    Sorry for the inconvenience,we have proccessed your case against the Transaction {{$htmldata["transactiond_id"]}}.<br>
    Please Use the link to know your case status <a href="{{$htmldata['customer_url']}}".>Case Status</a><br>
    Thank you Flakpay 
</body>
</html>
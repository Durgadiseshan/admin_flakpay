<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flakpay</title>
    <style>
    @media screen and (min-width: 480px) {
        .blog-container {
            width: 28rem;
       }
    }
    @media screen and (min-width: 767px) {
        .blog-container {
            width: 40rem;
       }
    }
    @media screen and (min-width: 959px) {
        .blog-container {
            width: 50rem;
       }
    }
    </style>   
</head>
<body style=" background: #e5ded8;box-sizing: border-box;">

    <div class="blog-container" style=" background: #fff;border-radius: 5px;box-shadow: rgba(0, 0, 0, .2) 0 4px 2px -2px;font-family: adelle-sans, sans-serif;font-weight: 100;margin: 45px auto;">
      
      <div class="blog-header">
        <div style="background: #061f5f;background-size: cover;border-radius: 5px 5px 0 0;height: 15rem;box-shadow: inset rgba(0, 0, 0, .2) 0 64px 64px 16px;">
          <div style="margin: 0 auto;padding-top: 0.125rem;width: 80%;">
            <h4 style="color: #fff;font-weight: 800;font-size: 26px; text-align: center;margin-top: 30px;line-height: 21px;">Invoice from {{$htmldata["business_name"]}}</h4>
            <div style="color: #fff;font-weight: 400;text-align: center;margin-top: 30px;line-height: 21px;">
              <p>Invoice Id : {{$htmldata["paylink_id"]}}</p>
            <p>{{$htmldata["business_name"]}} has sent you invoice of INR {{number_format($htmldata["amount"],2)}}</p>
            </div>
          </div>
        </div>
      </div>
    
      <div style=" margin: 0 auto;width: 80%;">
        <div >
          <p style="color: #333;font-weight: 700;">Billing to</p>
        </div>
        <div>
          <p class="text-primary" style="text-decoration: underline;color: #178ddb;font-size: 15px;line-height: 45px;">{{$htmldata["email"]}}</p>
        </div>
        <hr style="border-top: 1px dotted rgb(241, 241, 241);">
        <div>
          <p style="color: #333;font-weight: 650;">Amount Payable</p>
        </div>
        <a href="{{$htmldata['invoice_url']}}" style="background-color: #178ddb;color: white;padding: 12px;border-radius: 7px;font-family: adelle-sans, sans-serif;cursor: pointer;float: right;font-weight: 600;">Proceed To Pay</a>
       
        <h4 style="font-weight: 700; font-size: 22px;line-height: 38px;">INR {{number_format($htmldata["amount"],2)}}</h4>
      </div>
      
      <div class="blog-footer m-2">
        <hr style="border-top: 1px dotted rgb(241, 241, 241); width: 90%;">
            <p style="text-align: center;padding: 7px 0px;">{{$htmldata["business_name"]}}</p>
      </div>
      <hr style="border-top: 1px dotted rgb(241, 241, 241);width: 90%;">

      <div style="font-size: 13px;position: relative;right: 20px;top: 40px;font-family: 'Open Sans', sans-serif;">
        <p style="float: right;">You can reach out to us <span style="color: #178ddb;text-decoration: underline;cursor: pointer;">here</span> for any other query</p>
      </div>

      <div style="margin-left: 30px;">
        <img src="{{asset('assets/img/rockpay.png')}}" width="100" alt="Payflash">
      </div>

    </div>
</body>
</html>
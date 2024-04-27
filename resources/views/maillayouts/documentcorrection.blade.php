<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
    <body style="margin:0;padding:0">
        <div style="width:100%;min-width:320px; font-family:Helvetica,Arial;font-weight:bold;font-size:24px;background-size: contain;background-repeat: no-repeat;">
        <div>
          <div style="margin:0 auto; width:100%;max-width:598px;text-align:center;background-color:#fff">
            <table style="width:100%;max-width:599px;font-family:Arial;font-size:16px;color:#868686;background-color:#efefeb;border: 1px solid rgb(167, 167, 167);" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="background-color:#efefeb;width:auto"> </td>
                  <td style="background-color:#efefeb;text-align:center;width:75px">
                    <div style="width: 130px;">
                      <img style="vertical-align:bottom;width:130px;margin-top: 8px;" src="{{asset('assets/img/flakpay_logo.png')}}" alt="Payflash">
                    </div>
                  </td>
                  <td style="padding-top:30px;height:38px;background-color:#efefeb;width:auto"> </td>
                </tr>
              </tbody>
            </table>
            @if(!$htmldata["merchant_details"]->isEmpty())
            <table style="width:100%;max-width:600px;font-family:Arial;font-size:16px;color:#868686;background-color:#061f5f;table-layout:fixed;border: 1px solid rgb(167, 167, 167);" cellspacing="0" cellpadding="0" border="0">
              <thead>
                <th colspan="3">
                 <p style="text-align:center;width:auto;background-color:#fff;padding: 20px 0;font-size: 24px;font-weight: 550;color: #061f5f;border-bottom: 1px solid rgb(167, 167, 167);margin: 0px;">{{$htmldata["detailHeading"]}}</p>
                 <p style="text-align:left;width:auto;background-color:#fff;padding: 20px 0;padding-left:10px;font-size: 24px;font-weight: 550;color: #061f5f;margin:0px">Hello {{$htmldata["merchanName"]}},</p>
                 <p style="text-align:center justify;line-height: 26px; width:auto;background-color:#fff !important;padding: 12px 20px;font-size: 15px;font-weight: 400;color:#000;margin: 0px;">{{$htmldata["docMessage"]}}</p>
                </th>
              </thead>
               <tbody>
                 <tr  style="text-align:center;width:auto;background-color:#178ddb;color: white; padding: 30px 0;font-size: 18px;border-bottom: 1px solid #ccc;">
                   <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Sno</td>
                   <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Field Name</td>
                   <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Status</td>
                 </tr>
                   @foreach($htmldata["merchant_details"] as $index => $merchant_details)
                   <tr  style="text-align:center;width:auto;background-color:#fff;padding: 30px 0;font-size: 15px;font-weight: 400;">
                       <td style="padding: 20px 0;border-bottom: 1px solid #ccc">{{$index+1}}</td>
                       <td style="padding: 20px 0;border-bottom: 1px solid #ccc">{{$htmldata["detail_names"][$merchant_details->field_name]}}</td>
                       <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Correction Required</td>
                   </tr>
                   @endforeach
               </tbody>
             </table>
             <br>
             @endif
             @if(!$htmldata["docs"]->isEmpty())
            <table style="width:100%;max-width:600px;font-family:Arial;font-size:16px;color:#868686;background-color:#061f5f;table-layout:fixed;border: 1px solid rgb(167, 167, 167);" cellspacing="0" cellpadding="0" border="0">
             <thead>
               <th colspan="3">
                <p style="text-align:center;width:auto;background-color:#fff;padding: 20px 0;font-size: 24px;font-weight: 550;color: #061f5f;border-bottom: 1px solid rgb(167, 167, 167);margin: 0px;">{{$htmldata["docHeading"]}}</p>
                <p style="text-align:left;width:auto;background-color:#fff;padding: 20px 0;padding-left:10px;font-size: 24px;font-weight: 550;color: #061f5f;margin:0px">Hello {{$htmldata["merchanName"]}},</p>
                <p style="text-align:center justify;line-height: 26px; width:auto;background-color:#fff !important;padding: 12px 20px;font-size: 15px;font-weight: 400;color:#000;margin: 0px;">{{$htmldata["docMessage"]}}</p>
               </th>
             </thead>
              <tbody>
                <tr  style="text-align:center;width:auto;background-color:#178ddb;color: white; padding: 30px 0;font-size: 18px;border-bottom: 1px solid #ccc;">
                  <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Sno</td>
                  <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Document Name</td>
                  <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Status</td>
                </tr>
                  @foreach($htmldata["docs"] as $index => $docObject)
                  <tr  style="text-align:center;width:auto;background-color:#fff;padding: 30px 0;font-size: 15px;font-weight: 400;">
                      <td style="padding: 20px 0;border-bottom: 1px solid #ccc">{{$index+1}}</td>
                      <td style="padding: 20px 0;border-bottom: 1px solid #ccc">{{$htmldata["docsName"][$docObject->doc_name]}}</td>
                      <td style="padding: 20px 0;border-bottom: 1px solid #ccc">Invalid Document</td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            @endif
            <p style="text-align:center justify; width:auto;background-color:#fff;padding: 12px 20px;font-size: 15px;font-weight: 400;color: rgb(143, 143, 143);">&copy; Copyright Designed By <a href="{{secure_url('/')}}"><span style="color: #178ddb;text-decoration: underline;">Flakpay</span></a></p>
          </div>
        </div>
       
        </div>
        
</body>
</html>
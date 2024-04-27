<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flakpay</title>
    <style>
      @media (max-width: 567px){
        .para{
          position: relative;
          right: 21px;
          font-size: 15px !important;
        }
      }
      @media (max-width: 414px){
        .para{
          position: relative;
          right: 29px;
          font-size: 13px !important;
        }
      }
    </style>
</head>

    <body style="margin:0;padding:0">

        <div style="width:100%;min-width:320px;font-family:Helvetica,Arial;font-weight:bold;font-size:24px;background-color:#efefeb">
          <div style="margin:0 auto;width:100%;max-width:598px;text-align:center;background-color:#061f5f">
            <table style="width:100%;max-width:599px;font-family:Arial;font-size:16px;color:#868686;background-color:#efefeb" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="background-color:#efefeb;width:auto"> </td>
                  <td style="background-color:#efefeb;text-align:center;width:75px">
                    <div style="position: relative;">
                      <img style="vertical-align:bottom;width:100px;min-height:38px;margin-top: 8px;" src="{{asset('new/img/flakpay_logo.png')}}">
                    </div>
                  </td>
                  <td style="padding-top:30px;height:38px;background-color:#efefeb;width:auto"> </td>
                </tr>
              </tbody>
            </table>
            <table style="width:100%;max-width:600px;font-family:Arial;font-size:16px;color:#868686;background-color:#061f5f;table-layout:fixed" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr style="background-color:#061f5f">
                  <td style="text-align:center;width:auto;background-color:#061f5f"> </td>
                  <td style="height:38px;text-align:center;width:75px;background-color:#061f5f">
                  
                  </td>
                  <td style="text-align:center;width:auto;background-color:#061f5f"> </td>
                </tr>
              </tbody>
            </table>
            <div style="font-size:0;background-color:#061f5f;height: auto;">
             
              <div style="display:inline-block;width:70%;vertical-align:top;color:#f7f7f7;text-align:center">
                <div>
                  <img src="{{asset('/assets/img/email.png')}}" width="180" alt="" style="margin-top: 40px;">
                </div>
                <div style="font-size:29px;font-weight:bold;padding-bottom:12px;padding-top:25px;color: rgb(212, 211, 211);">Verify your login</div>
                <hr style="width:80%;border:1px solid #2f6577">
                <div style="font-size:18px;font-weight:550;padding-top:12px;padding-bottom:6px;color: rgb(212, 211, 211);">Hi {{$htmldata["employee_name"]}}, <br>Below is your one time passcode for this session</div>
                <table style="margin:auto">
                  <tbody>
                    <tr>
                      <td style="color:#fff;font-size:46px;padding-right:6px;position: relative;bottom: 50px; white-space:nowrap;text-decoration:none">
                      <h4>{{$htmldata["otp"]}}</h4>
                      <p class="para" style="font-size: 17px;color: rgb(212, 211, 211);position: relative;bottom: 12px;">We're here to help you. Visit <span style="text-decoration: underline;">Flakpay/support</span> <br> for more info or <span style="text-decoration: underline;">contact-us</span></p>
                     </td>
                    </tr>
                  </tbody>
                </table>
          
              </div>
            </div>
          </div>
        </div>
        
</body>
</html>
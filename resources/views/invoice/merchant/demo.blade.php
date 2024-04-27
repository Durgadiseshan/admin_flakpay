<!DOCTYPE html>
<html>
<title> {{$data['page_title']}} Default Format</title>



<head>


<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    font-family: 'Open Sans', 'Martel Sans', sans-serif;
}
th, td {
    padding: 5px;
    text-align: left;   
    vertical-align:top 
}
body{
  word-wrap: break-word;
}

          @page {
                margin: 100px 25px;
            }

            header {
                position: fixed;
                top: -60px;
                height: 50px;
                background-color: #752727;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed;
                bottom: -60px;
                height: 50px;
                background-color: #752727;
                color: white;
                text-align: center;
                line-height: 35px;
            }
</style>
</head>
<body onload="window.print();"><!--  -->

        <header>
             
     
     header
        </header>

        <footer>
            Footer
        </footer>
        <img width='100%' height='auto' src="https://yourbackers.org/rockpay_invoice_assets/rockpay.png" alert="test">
        <main>
 
         
        </main>


</body>
</html>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Mail</title>
 </head>
<style>
    .header,.footer{
        background-color: silver;
        color: #fff;
        text-align: center;
        padding: 10px;
    }
</style>


 <body>
         <div class="header">
          Cassava
    </div>

    @yield('content') 
<div class="footer">
 Cassava Team
</div>

 </body>
 </html>
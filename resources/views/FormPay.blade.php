<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
       

        <title>Laravel</title>

    </head>

    <body >
        <form method="POST" action="{{ route('payMent') }}">
            <input type="text" name="Username" value="user134755515">
            <input type="password" name="Password" value="52846752">
            <input type="number" name="Amount" value="50000">
            <input type="text" name="Wage" value="4"> 
            <input type="number" name="TerminalId" value="134755516"> 
            <input type="number" name="ResNum" value="{{ random_int(1403, 99999999) }}"> 
            <input type="text" name="CellNumber" value="09227659746"> 
            <input type="text" name="RedirectURL" value="http://localhost:8000/api/order/Payment"> 
            <input type="number" name="tickets_id" value="2"> 
            <select name="type" id="">
                <option value="Airplane" selected>Airplane</option>
                <option value="Train">Train</option>
            </select>
            <input type="text" value="31" name="Passengers[]">
            <input type="text" value="32" name="Passengers[]">
            <input type="text" value="33" name="Passengers[]">
            <button type="submit">save</button>
        </form>
    </body>
</html>

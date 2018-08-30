<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Event Sourcing</title>
    </head>
    <body>
<pre>
{{ (new \Illuminate\Support\Debug\Dumper)->dump($entity) }}
</pre>
    <form method="post" action="{{ route('buy', [$entity->getAccountId()]) }}">
        Purchase amount:  <input type="number" value="5" name="amount"><br>
        <button type="submit">Submit</button>
    </form>
    </body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        img {
            float: left;
        }
        p{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

        @foreach($users as $user)
            <div class="flex" style="flex-direction: row; height: auto">
                <div style="margin: 0 20px; display: flex; flex-direction: row; justify-content: center; justify-items: center; align-items: end">
                    <img style="border-radius: 1rem;" width="100" height="80" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($user->avatar))) }}">
                </div>
                <div class="flex flex-col" style="padding-left: 2rem; height: 120px">
                    <p>{{ $user->full_name }}</p>
                    <p>{{ $user->telephone }}</p>
                    <p style="text-underline: blue; color: #0a53be">{{ $user->email }}</p>
                    <p>{{ $user->rol_label }}</p>
                </div>
            </div>
        @endforeach

</body>
</html>
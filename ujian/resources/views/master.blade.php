<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pengguna</title>
</head>
<body>
    <h1>Selamat Datang, Admin!</h1>
    <h3>Data Pengguna</h3>
    <table border="1" cellspacing="0" cellpadding="8">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->password }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

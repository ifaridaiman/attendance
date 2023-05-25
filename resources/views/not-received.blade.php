<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <header class="w-100 d-flex flex-wrap align-items-center justify-content-center justify-content-md-center">


                <p class="text-center text-white m-0">
                  List not receive lucky draw
                  </p>
              </header>
        </div>
    </header>

    <div class="px-4 mt-5">
        <table id="attendees-data" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Department</th>

                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $key => $value)
                    <tr>
                        <td style="vertical-align: middle;">{{ $value->name }}</td>
                        <td style="vertical-align: middle;">{{ $value->department }}</td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</body>
</html>

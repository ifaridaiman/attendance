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
            <header class="w-100 d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                </a>

                <p class="text-center text-white m-0">
                  Attendance Sheet
                  </p>

                <div class="col-md-3 text-end">
                    <button class="btn btn-primary mx-2 float-end" onclick="toggleBestDressSection()">Show Best Dress</button>
                </div>
              </header>
        </div>
    </header>

    <div class="mt-5 px-4" id="best-dress" style="display: none;">
        <div class="row">
            @foreach($best_dress_department as $key => $value)
                <div class="col-4 mb-3">
                    <div class="card">
                        <h5 class="card-header">{{ $value->department }}</h5>
                        <div class="card-body">
                            <h5 class="card-title">{{ $value->total_nominees }} </h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-5 px-4">

        <form action="{{ route('attendance.search') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Attendee's Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                <a href="{{ route('attendance.index') }}" class="btn btn-danger" type="reset">Reset</a>
            </div>
        </form>
        <table id="attendees-data" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Registration</th>
                    <th>Best Dress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $key => $value)
                    <tr>
                        <td style="vertical-align: middle;">{{ $value->name }}</td>
                        <td style="vertical-align: middle;">{{ $value->department }}</td>
                        <td style="vertical-align: middle;">
                            @if ($value->present == 0)
                                <form id="registrationForm_{{ $value->id }}" action="{{ route('attendance.validateRegistration', $value->id) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <button class="btn btn-primary" type="submit" onclick="confirmRegistration({{ $value->id }},'{{ $value->name }}', event)">Register</button>
                                </form>
                            @else
                                <div class="d-flex align-items-center">
                                    <p class="text-success m-0 fw-bold">Registered</p>
                                </div>
                            @endif
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($value->best_dress == 0)
                                <form action="{{ route('attendance.validateBestDress', $value->id) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-primary" type="submit">Nominate</button>
                                    </div>
                                </form>
                            @else
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <p class="text-success m-0 fw-bold">Nominated</p>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <form action="{{ route('attendance.cancelBestDress', $value->id) }}" method="POST">
                                            @method('PATCH')
                                            @csrf
                                            <button class="btn btn-danger" type="submit">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <script>
        function confirmRegistration(id,name,event) {
            console.info(id,name,event);
            event.preventDefault();
            if (confirm("You are registering " + name + ", are you confirm?")) {
                document.getElementById("registrationForm_" + id).submit();
            }
        }
    </script>
    <script>
        function toggleBestDressSection() {
            var bestDressSection = document.getElementById('best-dress');
            if (bestDressSection.style.display === 'none') {
                bestDressSection.style.display = 'block';
            } else {
                bestDressSection.style.display = 'none';
            }
        }
    </script>
</body>
</html>

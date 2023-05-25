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
            <div class="container d-flex justify-content-center">
                <p class="text-center text-white m-0">
                    AV List
                </p>
            </div>
        </div>
    </header>
    <div class="container mt-5 ">
        <h5>List of Best Dress</h5>
        <table id="attendees-data" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Department</th>

                </tr>
            </thead>
            <tbody>
                @foreach($best_dress_nominees as $key => $value)
                    <tr>
                        <td style="vertical-align: middle;">{{ $value->name }}</td>
                        <td style="vertical-align: middle;">{{ $value->department }}</td>

                    </tr>
                @endforeach

            </tbody>
        </table>



    </div>


    <div class="container mt-5 ">
        <h5>List of not Received Lucky Draw</h5>

        <div class="row border p-3">
            @foreach($present as $key => $value)
                @if($value->department != 'Guest')
                    <p class="m-0">{{ $value->name }}</p>
                @endif
            @endforeach
        </div>
    </div>

    <script>
        function copyToClipboard() {
            console.log("test copy")
            const textToCopy = document.querySelector('.copy-raw').innerText;
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    alert('Copied to clipboard: ' + textToCopy);
                })
                .catch((error) => {
                    console.error('Unable to copy to clipboard:', error);
                });
        }
    </script>

</body>
</html>

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
                    Best Dress Nomination
                </p>
            </div>
        </div>
    </header>
    <div class="container mt-5">
        <div class="row">
            @foreach($best_dress_department as $key => $value)
                <div class="col-4">
                    <div class="card">
                        <h5 class="card-header">{{ $value->department }}</h5>
                        <div class="card-body">
                            <h5 class="card-title">{{ $value->total_nominees }} </h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="copy-raw">
            @foreach($best_dress_nominees as $key => $value)
                    {{ $value->name }}
            @endforeach
            <button class="btn btn-primary" onclick="copyToClipboard()">Copy</button>
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

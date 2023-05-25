<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <h5 class="card-title" id="total-nominees-{{ $value->department }}">{{ $value->total_nominees }}</h5>
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
                    <th>Lucky Draw</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $key => $value)
                    <tr id="attendee-{{ $value->id }}">
                        <td style="vertical-align: middle;">{{ $value->name }}</td>
                        <td style="vertical-align: middle;">{{ $value->department }}</td>
                        <td style="vertical-align: middle;">
                            @if ($value->present == 0)
                                <form id="registrationForm_{{ $value->id }}" action="{{ route('attendance.validateRegistration', $value->id) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <button class="btn btn-danger" type="submit" onclick="confirmRegistration({{ $value->id }},'{{ $value->name }}', event)">Register</button>
                                </form>
                            @else
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <p class="text-success m-0 fw-bold">Registered</p>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <form action="{{ route('attendance.cancelRegistration', $value->id) }}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Cancel</button>
                                    </form>
                                </div>
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
                        <td style="vertical-align: middle;">
                            @if ($value->lucky_draw == 0)
                            @if($value->department != 'Guest')
                            <form action="{{ route('attendance.validateLuckyDraw', $value->id) }}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#prizeModal">Received</button>
                                </div>

                                <!-- Prize Modal -->
                                <div class="modal fade" id="prizeModal" tabindex="-1" aria-labelledby="prizeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="prizeModalLabel">Select Prize Type</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Add your prize selection options here -->
                                                <!-- For example, radio buttons for different prize types -->
                                                <div class="form-group">
                                                    <label for="prizeDropdown">Select Prize:</label>
                                                    <select id="prizeDropdown" class="form-select" name="selectedPrizeType">
                                                        <option value="">Select Prize</option>
                                                        <option value="AEON VOUCHER 100">AEON Voucher 100</option>
                                                        <option value="AEON VOUCHER 150">AEON Voucher 150</option>
                                                        <option value="AEON VOUCHER 250">AEON Voucher 250</option>
                                                        <option value="AEON VOUCHER 300">AEON Voucher 300</option>
                                                        <option value="AEON VOUCHER 350">AEON Voucher 350</option>
                                                        <option value="AEON VOUCHER 500">AEON Voucher 500</option>
                                                        <option value="TEFAL RICE COOKER 1.8L">TEFAL Rice Cooker 1.8L</option>
                                                        <option value="SAMEL 3 IN 1 SET FGD 363 JAPANESES CONCEPT EXPANDABLE ANTI THEFT ZIPPER PP LUGGAGE 20&quot; 24&quot; 28&quot;">SAMEL 3 IN 1 SET FGD 363 JAPANESES CONCEPT EXPANDABLE ANTI THEFT ZIPPER PP LUGGAGE 20&quot; 24&quot; 28&quot;</option>
                                                        <option value="Breville Je95 Juice Fountain Large Feed Chute">Breville Je95 Juice Fountain Large Feed Chute</option>
                                                        <option value="PerySmith Cordless Vacuum Cleaner Xtreme Pro Series XP6">PerySmith Cordless Vacuum Cleaner Xtreme Pro Series XP6</option>
                                                        <option value="Travel Voucher (RM1000)">Travel Voucher (RM1000)</option>
                                                        <option value="Theragun Mini">Theragun Mini</option>
                                                        <option value="Nintendo Switch OLED">Nintendo Switch OLED</option>
                                                        <option value="Samsung 35L Convection Microwave Oven with HOT BLAST">Samsung 35L Convection Microwave Oven with HOT BLAST</option>
                                                        <option value="DJI Osmo Action 3 - Action Camera">DJI Osmo Action 3 - Action Camera</option>
                                                        <option value="Samsung Galaxy Tab S7 FE (64GB)">Samsung Galaxy Tab S7 FE (64GB)</option>
                                                        <option value="Apple Watch Series 8">Apple Watch Series 8</option>
                                                        <option value="Osim Office Massage Chair (black)">Osim Office Massage Chair (black)</option>
                                                        <option value="iPad Air (5th Generation) - 64GB">iPad Air (5th Generation) - 64GB</option>
                                                        <option value="iPhone 14 Pro - 256GB">iPhone 14 Pro - 256GB</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" onclick="setSelectedPrizeType()">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        @endif

                            @else
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <p class="text-success m-0 fw-bold">Received</p>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <form action="{{ route('attendance.cancelLuckyDraw', $value->id) }}" method="POST">
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

@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="tournament-section tournament-main">
        <div class="container">
            <div class="page-header profile-text">
                <h4>Tạo giải đấu</h4>
                <small>Chọn hình thức thi đấu phù hợp với số lượng đội bóng dự diến tham gia</small>
            </div>
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 create-tournament">
                            {{-- <form action="" method=""> --}}
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <label>Banner giải đấu</label>
                                        <br><small>(banner, poster, logo)</small>
                                    </div>
                                    <div class="logo-tournament">
                                        <img src="{{ asset('/storage/avatars/avatar_default.jpg') }}">
                                        <button type="button" class="btn btn-submit set-logo-tournament" data-toggle="modal" data-target="#avatarModal">
                                            Cập nhật
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <br>
                                    <div class="form-group">
                                        <label>Tên giải đấu</label> 
                                        <input class="form-control" type="text" name="username" value="">
                                        @if ($errors->has('username'))
                                            <p class="error-danger">{{ $errors->first('username') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Giới tính</label>
                                        <input class="form-control" type="text" name="email" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Sân thi đấu</label>
                                        <input class="form-control" type="string" name="phone" value="">
                                    </div>
                                    <div class="form-group">
                                        <label>Địa điểm</label>
                                        <input class="form-control" type="string" name="phone" value="">
                                    </div>
                                </div>
                                
                                <!-- Hình thức thi đấu -->
                                <div class="tournament-type">
                                    <div class="form-group">
                                        <label>Hình thức thi đấu</label>
                                        <!-- Tab list -->
                                        <div class="tablist">
                                            <button class="tablink" onclick="openPage('Home', this, '#326295')"  id="defaultOpen">Home</button>
                                            <button class="tablink" onclick="openPage('News', this, '#326295')">News</button>
                                            <button class="tablink" onclick="openPage('Contact', this, '#326295')">Contact</button>
                                        </div>
                                         <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div id="Home" class="tabcontent">
                                                <h3>Home</h3>
                                                <p>Home is where the heart is..</p>
                                            </div>
                                            <div id="News" class="tabcontent">
                                                <h3>News</h3>
                                                <p>Some news this fine day!</p>
                                            </div>
                                            <div id="Contact" class="tabcontent">
                                                <h3>Contact</h3>
                                                <p>Get in touch, or swing by for a cup of coffee.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script>
        // Tablink Js
        function openPage(pageName, elmnt, color) {
            // Hide all elements with class="tabcontent" by default */
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            // Remove the background color of all tablinks/buttons
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            // Show the specific tab content
            document.getElementById(pageName).style.display = "block";
            // Add the specific color to the button used to open the tab content
            elmnt.style.backgroundColor = color;
        }
        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
@endsection
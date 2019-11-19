@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="tournament-section tournament-main">
        <div class="container">
            <div class="page-header profile-text">
                <h4>Tạo giải đấu</h4>
                <small>Chọn hình thức thi đấu phù hợp với số lượng đội bóng tham gia</small>
            </div>
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 create-tournament">
                            {{-- <form action="#" method="post" enctype="multipart/form-data"> --}}
                                {{-- {{ csrf_field() }} --}}
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
                                <div class="col-md-12">
                                    <div class="tournament-type">
                                        <div class="form-group">
                                            <label>Hình thức thi đấu</label>
                                            <!-- Tab list -->
                                            <div class="tablist">
                                                <button class="tablink" onclick="openPage('Home', this, '#326295')"  id="defaultOpen">
                                                    <small>Đấu loại trực tiếp</small>
                                                    <img src="{{ asset('images/logo/format01.png') }}" class="image-circle">
                                                </button>
                                                <button class="tablink" onclick="openPage('News', this, '#326295')">
                                                    <small>Đấu vòng tròn</small>
                                                    <img src="{{ asset('images/logo/format02.png') }}" class="image-circle">
                                                </button>
                                                <button class="tablink" onclick="openPage('Contact', this, '#326295')">
                                                    <small>Đấu hai giai đoạn</small>
                                                    <img src="{{ asset('images/logo/format03.png') }}" class="image-circle">
                                                </button>
                                            </div>
                                            <!-- Tab content -->
                                            <div class="tab-content">
                                                <div id="Home" class="tabcontent">
                                                    <div class="form-group">
                                                        <label>Số đội tham gia</label>
                                                        <small>(phù hợp từ 2-64 đội)</small>
                                                        <input class="form-control" type="number" name="phone" value="">
                                                    </div>
                                                </div>
                                                <div id="News" class="tabcontent">
                                                    <div class="form-group">
                                                        <label>Số đội tham gia</label>
                                                        <small>(phù hợp từ 2-30 đội)</small>
                                                        <input class="form-control" type="number" name="phone" value="">
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label>Điểm thắng:</label>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <label>Điểm hòa:</label>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <label>Điểm thua:</label>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Số lượt đá vòng tròn</label>
                                                        <small>(lượt đi, lượt về)</small>
                                                        <div class="btn-group btn-group-justified btn-group-outline"  data-toggle="buttons">
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" checked="checked" name="optionsRound" type="radio" value="1">1 lượt
                                                            </label>
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" name="optionsRound" type="radio" value="2">2 lượt
                                                            </label>
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" name="optionsRound" type="radio" value="3">3 lượt
                                                            </label>
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" name="optionsRound" type="radio" value="4">4 lượt
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="Contact" class="tabcontent">
                                                    <div class="form-group">
                                                        <label>Số đội tham gia</label>
                                                        <small>(phù hợp từ 2-64 đội)</small>
                                                        <input class="form-control" type="number" name="phone" value="">
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-6">
                                                            <label>Số bảng đấu</label><br>
                                                            <small>(giai đoạn 1: chia bảng đấu vòng tròn)</small>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <label>Số đội vào vòng knockout</label><br>
                                                            <small>(giai đoạn 2: loại trực tiếp)</small>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Số đội tham gia</label>
                                                        <small>(phù hợp từ 2-64 đội)</small>
                                                        <input class="form-control" type="number" name="phone" value="">
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label>Điểm thắng:</label>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <label>Điểm hòa:</label>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <label>Điểm thua:</label>
                                                            <input class="form-control" type="number" name="phone" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Số lượt đá vòng tròn</label>
                                                        <small>(lượt đi, lượt về)</small>
                                                        <div class="btn-group btn-group-justified btn-group-outline"  data-toggle="buttons">
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" checked="checked" name="optionsRound" type="radio" value="1">1 lượt
                                                            </label>
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" name="optionsRound" type="radio" value="2">2 lượt
                                                            </label>
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" name="optionsRound" type="radio" value="3">3 lượt
                                                            </label>
                                                            <label class="btn tabOption" for="single">
                                                                <input id="single" name="optionsRound" type="radio" value="4">4 lượt
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Số lượng cầu thủ -->
                                <div class="col-md-12">
                                    <!-- Số lượng cầu thủ -->
                                    <div id="number-member" class="form-group">
                                        <label>Số cầu thủ thi đấu trên sân:</label>
                                        <div class="btn-group btn-group-justified btn-group-outline"  data-toggle="buttons">
                                            <label class="btn tabOption" for="single">
                                                <input id="single" checked="checked" name="numberMember" type="radio" value="5">5
                                            </label>
                                            <label class="btn tabOption" for="single">
                                                <input id="single" name="numberMember" type="radio" value="7">7
                                            </label>
                                            <label class="btn tabOption" for="single">
                                                <input id="single" name="numberMember" type="radio" value="9">9
                                            </label>
                                            <label class="btn tabOption" for="single">
                                                <input id="single" name="numberMember" type="radio" value="11">11
                                            </label>
                                        </div>
                                    </div>
                                    <div class="allow-register form-group">
                                        <label>Cho phép đăng ký tham gia:</label>
                                        <small>Giải đấu này sẽ do bạn tự quản lý và không cho phép các đội bóng trong hệ thống đăng ký tham gia.</small>
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary submit">Tạo giải đấu</button>
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
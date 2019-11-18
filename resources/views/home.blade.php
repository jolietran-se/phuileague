@extends('layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <!-- Slide start here -->
    <div class="slider-section4 slider-main">
        <div id="slider-five" class="owl-carousel">
            <div class="item active">
                <img src="{{ asset('images/logo/slide.png') }}" alt="Slider image">
                <div class="dsc">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="slider-text text-center">
                                    <span><h3>Giải pháp đơn giản để tổ chức giải đấu bóng đá</h3><span>
                                    <h6>Hỗ trợ nhiều thể thức thi đấu</h6>
                                    <h6>Hướng dẫn chi tiết điều hành giải đấu</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="slider-text text-center">
                                    <h3 >200</h3>
                                    <div class="about-widget "><p>Giải đấu</p></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="slider-text text-center">
                                    <h3 class="slide-title ">400</h3>
                                    <div class="about-widget "><p>Đội bóng</p></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="slider-text text-center">
                                    <h3 class="slide-title ">800</h3>
                                    <div class="about-widget"><p>Cầu Thủ</p></div>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Slide end here -->

    <!-- Format start here -->
    <div class="format-section format-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class = "format-text text-center">
                        <h3>Hỗ trợ nhiều thể thức đấu loại cho giải đấu</h3>
                        <p>Các hình thức thi đấu phổ biến trong các giải bóng đá từ nghiệp dư đến chuyên nghiệp.</p>
                        <p>Tuân theo luật thi đấu hiện hành.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/logo/format01.png') }}">
                    <h6 class="format-title">Đấu loại trực tiếp</h6>
                    <div class="about-widget">
                        <p>Đây là hình thức thi đấu knockout, đội thua sẽ bị loại trực tiếp khỏi giải đấu.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/logo/format02.png') }}">
                    <h6 class="format-title">Đấu Vòng Tròn</h6>
                    <div class="about-widget">
                        <p>
                            Hay còn gọi là đá league. Mỗi đội bóng sẽ thi đấu lần lượt với tất các đội bóng khác.
                            Hình thức này cho phép tùy chỉnh điều lệ xếp hạng.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/logo/format03.png') }}">
                    <h6 class="format-title">Đấu Hai giai đoạn</h6>
                    <div class="about-widget">
                        <p>Bốc thăm chia bảng. Giai đoạn 1 đấu vòng tròn tính điểm mỗi bảng. Giai đoạn 2 là vòng knockout.</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit"><a href="#">Tạo giải đấu</a></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Format end here -->

    <!-- Menagement start here -->
    <img src="{{ asset('images/logo/paginate.png') }}">
    <div class="management-section management-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class = "management-text text-center">
                        <h3>Các giai đoạn cơ bản để điều hành một giải đấu</h3>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <span><i class="fa fa-plus-square icon-parent"></i></span>
                            <h6 class="management-title">Giai đoạn 1: Tạo giải đấu</h6>
                            <div class="about-widget">
                                <ul>
                                    <li><i class="fa fa-angle-right"></i>Loại trực tiếp</li>
                                    <li><i class="fa fa-angle-right"></i>Đấu vòng tròn</li>
                                    <li><i class="fa fa-angle-right"></i>Hai giai đoạn</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <span><i class="icon-parent fa fa-cogs"></i></span>
                            <h6 class="management-title">Giai đoạn 2: Tùy chỉnh giải đấu</h6>
                            <div class="about-widget">
                                <ul>
                                    <li><i class="fa fa-angle-right"></i>Nhập điều lệ, hình và đia điểm</li>
                                    <li><i class="fa fa-angle-right"></i>Nhập thông tin của đội/cầu thủ</li>
                                    <li><i class="fa fa-angle-right"></i>Mời người tham gia</li>
                                    <li><i class="fa fa-angle-right"></i>Lập lịch đấu</li>
                                    <li><i class="fa fa-angle-right"></i>Tùy chỉnh giai đoạn</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <span><i class="icon-parent fa fa-tasks"></i></span>
                            <h6 class="management-title">Giai đoạn 3: Điều hành</h6>
                            <div class="about-widget">
                                <ul>
                                    <li><i class="fa fa-angle-right"></i>Kích hoạt</li>
                                    <li><i class="fa fa-angle-right"></i>Nhập tỷ số</li>
                                    <li><i class="fa fa-angle-right"></i>Xem thống kê</li>
                                </ul>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menagement end here here -->

@endsection

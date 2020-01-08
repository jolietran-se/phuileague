@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tournament.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <!-- Setting tab list -->
    @include('layouts.setting')

    <div class="setting-section setting-main">
        <div class="container">
            <div class="col-md-3">
                <div id="tablist-setting">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="{{ route('tournament.setting', $tournament->slug)}}">Thông tin chung<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li class="active"><a href="{{ route('setting.groupstage', $tournament->slug)}}">Sắp xếp bảng đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.knockoutstage', $tournament->slug)}}">Sắp xếp loại trực tiếp<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        <li><a href="{{ route('setting.matchstage', $tournament->slug)}}">Sắp xếp cặp đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li><a href="{{ route('setting.schedule', $tournament->slug)}}">Quản lý lịch đấu<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        {{-- <li><a href="{{ route('setting.status', $tournament->slug)}}">Trạng thái<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.clubs', $tournament->slug)}}">Quản lý đội bóng<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.rankingrule', $tournament->slug)}}">Quy tắc xếp hạng<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                        {{-- <li><a href="{{ route('setting.supporter', $tournament->slug)}}">Nhà tài trợ<span class="glyphicon glyphicon-menu-right"></span></a></li> --}}
                    </ul>
                </div>
            </div>
            <div id="content" class="col-md-9">
                <div id="group-stage">
                    <div class="page-header profile-text text-center">
                        <h6><strong>Sắp xếp bảng đấu</strong></h6>
                        <small style="font-size: 13px">Số đội bóng: {{ $tournament->number_club }} | Số bảng đấu: {{ $tournament->number_group }} | Số đội vào vòng knockout: {{ $tournament->number_knockout }}</small>
                    </div>
                    <div id="list-group" class="col-md-12">
                        <input type="hidden" id="tournament-slug" value="{{ $tournament->slug }}">
                        <input type="hidden" id="number_knockout" value="{{$tournament->number_knockout}}">
                        <input type="hidden" id="groups" value="{{ $groups }}">
                        
                        <div class="form-group">
                            <p> Số đội vào vòng knockout:</p>
                            <input type="number" class="form-control" value="{{ $tournament->number_knockout }}" readonly>
                        </div>
                        <div class="form-group">
                            <p><b>Giải đấu gồm {{ $tournament->number_group }} bảng đấu</b></p>
                            <small>( Bạn có thể thay đổi bảng đấu cho đội bằng cách kéo thả đội bóng, chọn số đội đi tiếp vào vòng sau ở mỗi bảng)</small>
                        </div>
                        @foreach ($groups as $group)    
                            <div id="group-{{ $group->name }}" data-id="{{ $group->id }}" class="col-xs-12 col-sm-6 group">
                                <div class="group-container">
                                    <div class="page-header">
                                        <h6>
                                            BẢNG {{ $group->name }}
                                            <small data-id="{{ $group->id }}">
                                                chọn <input type="number" class="pass-group" min="1"
                                                    id="{{$group->name}}-pass" name="numSelect_{{$group->name}}" 
                                                    value="{{ $group->number_to_knockout }}"> 
                                                đội đi tiếp
                                            </small>
                                        </h6>
                                    </div>
                                    <div class="panel-body">
                                        <ul id="{{ $group->id }}">
                                            @php $index = 0; @endphp
                                            @foreach ($tournament->clubs as $club)
                                                @if ($club->pivot->group_id == $group->id)
                                                    @if ($index < $group->number_club)
                                                        <li draggable="true"
                                                            id="A{{ $index }}"
                                                            data-id="{{ $club->id }}" 
                                                            class="club1">{{ $club->name }}</li>
                                                    @php $index++; @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div id="notification" class="col-md-12"><!-- Thông báo --></div>
                        <div class="col-md-12">
                            <input type="submit" value="Lưu" class="btn btn-success submit-group">
                        </div>
                    </div>

                    <!-- Player Delete Modal -->
                    <div class="modal fade" id="updateGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h5 class="modal-title text-center" id="myModalLabel">
                                    <strong>Cảnh báo</strong>
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                </h5>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Các thông tin, kết quả của trận đấu, thông tin của bảng đấu sẽ bị thay đổi
                                    và không hoàn lại được.</p>
                                    <h6  class="text-center">Bạn có chắc chắn muốn thực hiện thay đổi?</h6>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger update-group" style="margin-right:45%">Đồng ý</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot')
    <script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript">
        $("#list-group" ).sortable({
            items: "li",
            cursor: 'move',
            opacity: 0.6,
        });
        $(document).on('click', '.submit-group', function(e){
            $('#updateGroup').modal('show');
            $(document).on('click', '.update-group', function(e){
                sendOrderToServer();
            });
        });
        // Lưu bảng
        function sendOrderToServer() {
            // Danh sách các đội lưu theo vị trí mới và groupID mới
            var order = [];
            $('li.club1').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    groupID:$(this).closest('ul').attr('id'),
                    position: index+1,
                });
            });
            
            // Danh sách số đội vào vòng knockout
            var knockout = [];
            $('input.pass-group').each(function(index,element){
                knockout.push({
                    groupID: $(this).closest('small').attr('data-id'),
                    number: $(this).val()
                });
            });
            // Danh sách các bảng đấu
            var groups = [];
            $('div.group').each(function(index, element){
                groups.push({
                    groupID: $(this).attr('data-id'),
                });
            });
            var flag = true;
            groups.forEach(function(item, index, array){
                var count = 0;
                $('#'+item['groupID']+' li.club1').each(function(index,element) {
                    count +=1;
                });
                if(count<2) flag = false;
            });

            // Nếu thỏa mãn về số đội thì lưu lại
            if(flag == true){
                 // Tống số đội vào vòng knockout
                var sum = 0;
                var number_knockout = $('#number_knockout').val();
                knockout.forEach(function(item, index, array) {
                    sum +=  parseInt(item['number']);
                });

                if(sum == number_knockout){
                    // Lưu thông tin
                    var slug = $('#tournament-slug').val();
                    url = " {{ route('setting.sort-group', ":slug") }}";
                    url = url.replace(':slug', slug);
                    console.log(url);
                    $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: url,
                        data: {
                            order:order,
                            knockout:knockout,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                console.log(response);
                            } else {
                                console.log(response);
                            }
                            $('#updateGroup').modal('hide');
                            location.reload();
                        }
                    });
                }else{
                    $('#updateGroup').modal('hide');
                    html = "<div class='alert alert-danger'> <span>Tổng số đội đi tiếp của các bảng phải bằng "+number_knockout+"</span> <br></div>"
                    $('#notification').html(html);
                }
            }else{
                $('#updateGroup').modal('hide');
                html = "<div class='alert alert-danger'> <span> Mỗi bảng phải có ít nhất 2 đội</span> <br></div>"
                $('#notification').html(html);
            }
        }
    </script>

    <script>
        toastr.options.positionClass = 'toast-top-right';
        @if(Session::has('group_stage'))
            toastr.success("{{ Session::get('group_stage') }}");
        @endif
    </script>
@endsection


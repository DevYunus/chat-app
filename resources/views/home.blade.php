@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-default">
                                <div class="panel-heading">Chat Message Module</div>
                                <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-8" >
                                      <div id="messages" ></div>
                                    </div>
                                    <div class="col-lg-8" >
                                            <form action="send" method="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                                <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
                                                <textarea class="form-control msg"></textarea>
                                                <br/>
                                                <input type="button" value="Send" class="btn btn-success send-msg">
                                            </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>

<script>
        var socket = io('http://localhost:3000');
        socket.on('message-sent:App\\Events\\MessageSent', function (data) {
            data = jQuery.parseJSON(data);
            console.log(data);
            $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
          });
          socket.on('hi', function (data) {

            console.log(data);
          });
        $(".send-msg").click(function(e){
            debugger;
            e.preventDefault();
            var token = $("input[name='_token']").val();
            var user = $("input[name='user']").val();
            var msg = $(".msg").val();
            if(msg != ''){
                $.ajax({
                    type: "POST",
                    url: '{!! URL::to("send") !!}',
                    dataType: "json",
                    data: {'_token':token,'message':msg,'user':user},
                    success:function(data){
                        console.log(data);
                        $(".msg").val('');
                    }
                });
            }else{
                alert("Please Add Message.");
            }
        })
    </script>
@endsection


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
                                            <form action="sendmessage" method="POST">
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
@section('content')
<script>
        var socket = io('http://127.0.0.1:3000');
        socket.on('event: App\\Events\\MessageSent', function (data) {

            data = jQuery.parseJSON(data);
            console.log(data);
            $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>" );
          });
        $(".send-msg").click(function(e){
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


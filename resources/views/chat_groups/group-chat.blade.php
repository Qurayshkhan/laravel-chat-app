@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Laravel Chat App') }}</div>

                    <div class="card-body">

                        <div class="container-fluid  border">
                            <div class="row p-3 border">
                                <div style="overflow: auto;max-height:300px">
                                    <div>
                                        <h1>{{ $group->name }}</h1>
                                    </div>
                                    <div class="result mt-3" id="group_list" style="cursor: pointer">

                                    </div>

                                </div>

                                <div class="message-box" id="messageBox" style="overflow: auto;max-height:300px">

                                </div>

                            </div>

                            <div class="row send-message">
                                <div class="d-flex justify-centent-between">
                                    <div class="col-md-4">

                                    </div>
                                    <div id="form" class="col-md-8 mt-2">
                                        <form id="form_message">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="" class="form-label"><strong>Type message here:</strong>
                                                </label>
                                                <textarea class="form-control" name="message" id="sent_message" rows="3" placeholder="write message"></textarea>
                                            </div>
                                            <div class="d-flex justify-content-end mb-2">
                                                <button class="btn btn-primary">send message</button>
                                            </div>
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
@endsection
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('2742598bce61202bc3db', {
        cluster: 'ap2'
    });
    var channel = pusher.subscribe('group-message');
    channel.bind('groupmessage-event', function(data) {
        alert(JSON.stringify(data));
    });
</script>
<script>
    $(document).ready(function() {

        $('#form').submit(function(e) {
            e.preventDefault();
            let url = `{{ URL('/group-message/' . $group->id) }}`;
            let form = $('form').serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: form,
                success: function(response) {
                    $('#form_message')[0].reset();
                    fetchGroupMessages();
                },
                error: function(error) {
                    console.log(error);
                }
            })
        });

        let fetchGroupMessages = () => {
            url = `{{ URL('/receive-group-messages/' . $group->id) }}`;
          let  user = {{auth()->user()->id}};
            $('.message-box').html("");
            $.get({
                type: "GET",
                url: url,
                success: function(response) {
                    $.each(response, function(key, value) {
                        key = key + 1;

                        if (user != value.user.id) {
                            $('.message-box').append(
                        `<div class="w-100 border border-primary p-3">
                                        <div>
                                            <h3>${value.user['name']}</h3>
                                            <p>${value.message}</p>
                                        </div>
                            </div> `
                        );
                        }else{
                            $('.message-box').append(
                        `<div class="w-100 border border-primary p-3 d-flex justify-content-end">
                                        <div>
                                            <h3>${value.user['name']}</h3>
                                            <p>${value.message}</p>
                                        </div>
                            </div> `
                        );
                        }

                    });

                }
            });
        }

        fetchGroupMessages();
    });
</script>

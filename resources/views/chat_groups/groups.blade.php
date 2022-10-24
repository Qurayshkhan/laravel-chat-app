@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Make Group') }}</div>

                    <div class="card-body">
                        <form id="group_form" action="{{route('groups.store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Enter name of group</label>
                                <textarea class="form-control" name="name" id="group_name" rows="3" placeholder="write name of group"></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" name="create_group"
                                    id="create_group_button">Create group</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid  border">
        <div class="row p-3 border">
            <div style="overflow: auto;max-height:300px">
                <div>
                    <h1>Groups</h1>
                </div>
                <div class="result mt-3" id="group_list" style="cursor: pointer">
                    @foreach ($groups as $group)
                    <a href="{{url('chat/'.$group->id)}}">
                        <div class="bg-primary text-light p-3 border">

                            <h3>{{$group->name}}</h3>
                        </div>
                    </a>

                    @endforeach
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
{{-- <script>
    $(document).ready(function() {


        $('#group_form').submit(function(e) {
            e.preventDefault();
            let form = $('#group_form').serialize();
            $.ajax({
                type: "POST",
                data: form,
                url: "{{ route('store-group') }}",
                success: function(response) {
                    // if (response) {
                    //     Swal.fire({
                    //         icon: 'success',
                    //         title: 'Create group successfully',
                    //         showConfirmButton: true,
                    //         confirmButtonText: 'OK'
                    //     }).then((response) => {
                    //         $('#group_form')[0].reset();
                    //         fetchGroups();
                    //     })
                    // }
                    $('#group_form')[0].reset();
                    fetchGroups();

                },
                error: function(error) {
                    console.log(error);
                }
            })
        });
        let fetchGroups = () => {
            $('.result').html("");
            $.get({
                type: "GET",
                url: "{{ route('groups.fetch') }}",
                success: function(response) {
                    $.each(response, function(index, value) {

                        index = index + 1;
                        $('.result').append(
                            `<a href="{{ url('/chat/${index}') }}"><div class ="bg-primary text-light p-2 rounded mt-2" group-id="${index}">${value.name}</div></a>`
                        );
                    })

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        fetchGroups();

    });
</script> --}}

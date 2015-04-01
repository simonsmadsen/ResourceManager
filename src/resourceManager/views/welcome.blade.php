@extends(config('resourceManager.yield-template'))

@section('content')


  <h1 >Resources</h1>
    <div class="row">
        <div class="col-md-2 admin-nav">

            <ul>
            @foreach($r->getResources() as $reasource)
                <li class="active">
                    <i class="icon-user list-group-item-icon"></i>
                    <a href="/res/{{$reasource->name}}">{{$reasource->name}}</a>
                </li>
            @endforeach
            </ul>
        </div>

        <div class="col-md-8">

            <table class="table table-stribe" data-fillAble="{{count($r->getResourceColumns('Flamingo'))}}">
                <thead>
                    <th>id</th>
                    @foreach($r->getResourceColumns('Flamingo') as $column)
                    <th>{{$column}}</th>
                    @endforeach

                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>change</th>
                    <th>delete</th>
                </thead>
                <tbody>

                    @foreach($r->getRowFor('Flamingo') as $row)
                     <tr>
                            <td>{{ $row->id  }}</td>
                        @foreach($r->getResourceColumns('Flamingo') as $column)
                            <td class="row-id-{{$row->id}}">{{ $row->$column }}</td>
                        @endforeach
                            <td>{{ $row->created_at  }}</td>
                            <td>{{ $row->updated_at  }}</td>
                            <td><button data-row="{{$row->id}}" class="btn-change-row btn btn-default">Change</button></td>
                            <td>
                            <a href="/res/delete/{{$row->id}}/{{ str_replace('\\','_',$r->getModelName())}}" class="btn btn-danger">Slet</a>
                            </td>
                     </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
</div>

<div class="row" id="change" style="display: none">

    <form action="/res/update" method="Post" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="updateId" name="id" value="" />
        <input type="hidden" name="resource_model" value="{{$r->getModelName()}}" />

        <div id="formBody">

        </div>

        <button type="submit" class="btn btn-default">Change</button>
    </form>

</div>

<button id="btn-create" class="btn btn-success">Create {{$r->getName()}}</button>

<div class="row" id="create" style="display: none">

    <form action="/res/create" method="Post" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="resource_model" value="{{$r->getModelName()}}" />


         @foreach($r->getResourceColumns('Flamingo') as $column)
              <div class="form-group">
                  <label for="{{$column}}">{{$column}}:</label>
                  <input type="text" name="{{$column}}" class="form-control" id="{{$column}}" placeholder="">
              </div>
         @endforeach

        <button type="submit" class="btn btn-default">Create</button>
    </form>

</div>




@stop

@section(config('resourceManager.yield-javascript'))


        <script>

            $('.btn-change-row').click(function(){

                $('#change').hide('fade');
                $('#create').hide('fade');


                var rowId = $(this).attr('data-row');

                var fillable = $('table').attr('data-fillAble');

                $('#formBody').html('');

                $('#updateId').val(rowId);

                for (i = 0; i < fillable; i++) {


                    $('#formBody').append('<div class="form-group"><label for="'+$('th').eq(i + 1).html()+'">'+$('th').eq(i + 1).html()+':</label><input type="text" name="'+$('th').eq(i + 1).html()+'" value="'+$('.row-id-'+rowId).eq(i).html()+'" class="form-control" id="'+$('th').eq(i + 1).html()+'" placeholder=""></div>')
                }

                $('#change').show('fade');

            });

            $('#btn-create').click(function(){
                $('#change').hide('fade');
                $('#create').show('fade');

            });


        </script>
@stop
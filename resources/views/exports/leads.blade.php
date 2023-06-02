            <table style="border:1px solid #ccc">

              <thead>
              <tr>
                  <td colspan="{{count($columns)+1}}" style="text-align: center">AFOHS CLUB - CRM LEADS</td>
              </tr>
                <tr>

                  <th class="wd-5p">#</th>
                 @foreach($columns as $col)
                     <th>{{$col}}</th>
                    @endforeach

                </tr>
              </thead>
        <tbody>
@foreach($data as $key=>$x)
    <tr>
        <td>{{$key+1}}</td>
    @foreach($columns as $c)
    <td>{{$x[$c]}}</td>
        @endforeach
    </tr>
    @endforeach

        </tbody>
            </table>

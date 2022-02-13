<!doctype html>
<html lang="ja">
<head>
  <title>Weather App</title>
  <!-- 必要なメタタグ -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <form action="{{route('weather.search')}}" method="post">
      @csrf
      <div class="post_code_input">
        <input type="text" imputmode="numeric" pattern="\d*" name="post_code1" placeholder="870" required>
        <span>-</span>
        <input type="text" imputmode="numeric" pattern="\d*" name="post_code2" placeholder="0026" required>
        <button type="submit" class="btn btn-primary search">検索する</button>
      </div>
      @if (session('error_message'))
        <div class="error_message">
          {{ session('error_message') }}
        </div>
      @endif
    </form>

    @if($weather_info)
    <div class="search_result">
      <p>{{$place_name->original}}の天気</p>
      <table class="table table-striped">
        <thead>
          <tr>
            <td>日付</td>
            <td>天気</td>
            <td>気温</td>
          </tr>
        </thead>
        <tbody>
          @foreach($weather_info['list'] as $wi)
            <tr>
              <td>{{date('m月d日 H時',  strtotime($wi['dt_txt']))}}</td>
              <td>{{$wi['weather'][0]['description']}}</td>
              <td>{{round($wi['main']['temp'])}}℃</td>
            </tr>
            @if(date('H',  strtotime($wi['dt_txt'])) == 21)
            <tr class="date-end"><td></td><td></td><td></td></tr>
            @endif
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
</body>
</html>

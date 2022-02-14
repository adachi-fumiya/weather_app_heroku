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
    <form action="{{route('weather.search')}}" method="get">
      <div class="post_code_input">
        <div class="zip">
          <input type="text" imputmode="numeric" pattern="\d*" maxlength="3" name="zip1" placeholder="870" required>
          <span>-</span>
          <input type="text" imputmode="numeric" pattern="\d*" maxlength="4" name="zip2" placeholder="0026" required>
        </div>
        <button type="submit" class="btn btn-primary search">検索する</button>
      </div>
      @if (session('error_message'))
        <div class="error_message">
          {!! nl2br(e(session('error_message'))) !!}
        </div>
      @endif
    </form>

    @if($weather_info)
    <div class="search_result">
      <p class="city_text">{{$place_name->original}}の天気</p>
      <table class="table table-striped">
        <thead>
          <tr class="head_tr">
            <td>日付</td>
            <td>天気</td>
            <td>気温</td>
          </tr>
        </thead>
        <tbody>
          <?php $week = ['日','月','火','水','木','金','土']; ?>
          @foreach($weather_info['list'] as $wi)
            <?php 
              $w = date('w',  strtotime($wi['dt_txt']));
              $convert_week = $week[$w];
            ?>
            <tr>
              <td>{{date("n/d($convert_week) H時",  strtotime($wi['dt_txt']))}}</td>
              <td>
                <!-- <img src="https://openweathermap.org/img/wn/{{$wi['weather'][0]['icon']}}@2x.png" alt=""> -->
                {{$wi['weather'][0]['description']}}
              </td>
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

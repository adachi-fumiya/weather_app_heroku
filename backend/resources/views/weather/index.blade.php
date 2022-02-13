<!doctype html>
<html lang="ja">
<head>
  <title>Weather App</title>
  <!-- 必要なメタタグ -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <form action="" method="post">
      <div class="form-group">
        <label>郵便番号を入力してください</label>
        <input type="text" name="body" class="form-control" placeholder="870-0148">
      </div>
      <button type="submit" class="btn btn-primary">検索する</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <td>日付</td>
          <td>天気</td>
          <td>気温</td>
        </tr>
      </thead>
      <tbody>
        @foreach($result_array['list'] as $r)
          <tr>
            <td>{{date('m月d日 H時',  strtotime($r['dt_txt']))}}</td>
            <td>{{$r['weather'][0]['description']}}</td>
            <td>{{round($r['main']['temp'])}}℃</td>
          </tr>
          @if(date('H',  strtotime($r['dt_txt'])) == 21)
          <tr class="date-end"><td></td><td></td><td></td></tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8" />
  <title>Topografie Europa Quiz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    #question {
      font-size: 24px;
      margin: 15px;
    }

    #score {
      margin-bottom: 10px;
      font-size: 18px;
      font-weight: bold;
    }

    #map {
      height: 90vh;
      width: 100%;
    }
  </style>
</head>

<body>
  <div id="question">Vraag wordt geladen...</div>
  <div id="score">Score: 0</div>
  <div id="map"></div>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="game.js"></script>
</body>

</html>
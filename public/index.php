<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wereldkaart met PHP</title>
  <script type="text/javascript" src="mapdata.js"></script>
  <script type="text/javascript" src="europemap.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Open Sans', sans-serif;
      line-height: 1.6;
      color: #333;
      background-color: #f5f7fa;
      padding: 20px;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    header {
      text-align: center;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eaeaea;
    }
    
    h1 {
      color: #2c3e50;
      font-size: 2.2rem;
      margin-bottom: 10px;
    }
    
    .subtitle {
      color: #7f8c8d;
      font-size: 1.1rem;
    }
    
    #map {
      width: 100%;
      height: auto;
      margin: 20px auto;
      border-radius: 8px;
      overflow: hidden;
    }
    
    footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 15px;
      border-top: 1px solid #eaeaea;
      color: #7f8c8d;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>Wereldkaart</h1>
      <p class="subtitle">Interactieve kaart van Europa</p>
    </header>
    
    <main>
      <div id="map"></div>
    </main>
    
    <footer>
      <p>&copy; 2025 Topografie Project</p>
    </footer>
  </div>
</body>
</html>
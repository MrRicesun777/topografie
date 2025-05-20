<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Europa Topografie</title>
    <style>
        /* Reset en basis */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body,
        html {
            height: 100%;
            width: 100%;
        }

        /* Achtergrondafbeelding fullscreen */
        body {
            background-image: url('https://european-union.europa.eu/sites/default/files/styles/oe_theme_medium_no_crop/public/2024-05/european-map_nl.jpg?itok=IaWyvkTL');
            /* mooie natuur/sky als voorbeeld */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Nav bar */
        nav {
            width: 100%;
            padding: 20px 40px;
            display: flex;
            justify-content: flex-end;
            background: rgba(0, 0, 0, 0.4);
            font-weight: 600;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffd700;
            /* goud kleur */
        }

        /* Content container */
        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;

        }




        /* Buttons container */
        .buttons {
            display: flex;
            gap: 30px;
            justify-content: center;
        }




        .btn {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 5px 15px rgba(0, 119, 204, 0.4);
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #005fa3;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 95, 163, 0.6);
        }

        h2 {
            color: black;
            font-size: 69px;
            margin-bottom: 200px;

        }
    </style>
</head>

<body>

    <nav>
        <a href="#">Inloggen</a>
    </nav>

    <div class="container">

        <h2>Wat wil je spelen?</h2>
        <div class="buttons">
            <a href="landen.php " class="btn">Landen</a>
            <a href="steden.php" class="btn">Steden</a>
        </div>

    </div>

</body>

</html>
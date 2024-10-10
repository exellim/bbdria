<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>card </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            /* display: flex; */
            min-height: 100vh;
            align-content: center;
            /* padding-block: 2rem; */
            /* padding-inline: 2rem; */
        }

        .container {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

        .container-fluid {
            display: flex;
            justify-content: center;
            align-items: center;
            /* flex-wrap: nowrap; */
        }

        /* Card container for responsive layout */
        /* .card-container { */
        /* display: inline-block; */
        /* justify-content: space-evenly; */
        /* flex-direction: row; */
        /* grid-auto-columns: auto; */
        /* grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); */
        /* gap: 20px; */
        /* padding: 20px; */
        /* max-width: 1200px; */
        /* width: 100%; */
        /* } */

        /* Card styling */
        .card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            max-width: 100%;
            width: 45%;
            margin-block: .5rem;
            margin-inline: .1rem;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        /* Card image with background image */
        .card-image {
            background-size: cover;
            background-position: center;
            height: 200px;
            width: 100%;
        }

        /* Card content */
        .card-content {
            padding: 20px;
            text-align: center;
        }

        .card-content h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .card-content p {
            font-size: 1em;
            color: #777;
        }

        .to-left {
            text-align: right;
        }

        #review option {
            color: goldenrod;
        }

        .btn {
            background-color: pink;
            color: #ffffff;
            font-weight: bold;
            width: 25%;
        }

        @media (max-width: 765px) {
            .to-left {
                text-align: left;
            }

            .btn {
                width: 50%;
            }
        }

        @media (max-width: 431px) {
            .col-md-6 {
                text-align: center !important;
            }

            .btn {
                width: 100%;
            }
        }

        @media only screen and (max-width: 1130px) {
            .container {
                display: flex;
                flex-direction: column;
            }

            .card {
                width: 50%;
                margin-block: 2rem;
            }
        }

        @media only screen and (max-width: 440px) {
            .card {
                width: 100%;
                margin-block: 2rem;
            }
        }

        textarea {
            width: 100%;
            /* height: 150px; */
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            resize: none;
        }

        .select-dropdown {
            background-color: tomato;
            border-radius: 2px;
            margin: 0 auto;
        }

        .select-dropdown {
            background-color: pink;
        }

        .select-dropdown select {
            width: 100%;
            background-color: pink;
            border: none;
            color: white;
        }

        select option {
            background-color: #ffffff;
        }
    </style>
</head>

<body style="background-color: #f9fcff;">
    <div class=" page-body-wrapper"
        style="justify-content: space-evenly; min-height: 100vh; align-items: center; display: flex;">
        <form method="POST" action="{{ route('review.store', $pics[0]->receipt_code) }}"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card-container row d-flex container"
                style="padding-block: 18px; width: 100%; justify-content: space-evenly; margin-block: 2rem">
                @foreach ($pics[0]->pics as $pic)
                    <div class="card">
                        {{-- <div class="card-image"></div> --}}
                        <div class="card-content">
                            <h3>{{ $pic->user->name }}</h3>
                            <div class="row" style="justify-content: space-evenly">
                                <div class="col-md-6 to-left" style="padding-block: 2px">
                                    Rate Me!
                                </div>
                                <input type="hidden" name="id_pic[]" value="{{ $pic->users_id }}">
                                <div class="col-md-6" style="text-align: left">
                                    <div class="select-dropdown">
                                        <select name="review[]" id="review">
                                            <option value="">Pick A Star</option>
                                            <option value="1">★</option>
                                            <option value="2">★★</option>
                                            <option value="3">★★★</option>
                                            <option value="4">★★★★</option>
                                            <option value="5">★★★★★</option>
                                        </select>
                                    </div>
                                </div>
                                <textarea name="review_pic[]" id="" cols="30" rows="5" placeholder="Tell us your experience"></textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div style="width: 100%; text-align: center; margin-top: 2rem;">
                    <button class="btn"><i class="fa fa-paper-plane-o"></i> Send Reviews</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>

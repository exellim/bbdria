<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet"> --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        :root {
            --primary: white;
            --bg-color: #254336;
            --bg-envelope-color: rgb(255, 192, 203);
            --envelope-tab: rgb(254, 150, 167);
            --envelope-cover: rgb(253, 113, 137);
            --shadow-color: #1c1c1c;
            --heart-color: #c2465d;
        }

        .poppins-thin {
            font-family: "Poppins", system-ui;
            font-weight: 100;
            font-style: normal;
        }

        .poppins-extralight {
            font-family: "Poppins", system-ui;
            font-weight: 200;
            font-style: normal;
        }

        .poppins-light {
            font-family: "Poppins", system-ui;
            font-weight: 300;
            font-style: normal;
        }

        .poppins-regular {
            font-family: "Poppins", system-ui;
            font-weight: 400;
            font-style: normal;
        }

        .poppins-medium {
            font-family: "Poppins", system-ui;
            font-weight: 500;
            font-style: normal;
        }

        .poppins-semibold {
            font-family: "Poppins", system-ui;
            font-weight: 600;
            font-style: normal;
        }

        .poppins-bold {
            font-family: "Poppins", system-ui;
            font-weight: 700;
            font-style: normal;
        }

        .poppins-extrabold {
            font-family: "Poppins", system-ui;
            font-weight: 800;
            font-style: normal;
        }

        .poppins-black {
            font-family: "Poppins", system-ui;
            font-weight: 900;
            font-style: normal;
        }

        .poppins-thin-italic {
            font-family: "Poppins", system-ui;
            font-weight: 100;
            font-style: italic;
        }

        .poppins-extralight-italic {
            font-family: "Poppins", system-ui;
            font-weight: 200;
            font-style: italic;
        }

        .poppins-light-italic {
            font-family: "Poppins", system-ui;
            font-weight: 300;
            font-style: italic;
        }

        .poppins-regular-italic {
            font-family: "Poppins", system-ui;
            font-weight: 400;
            font-style: italic;
        }

        .poppins-medium-italic {
            font-family: "Poppins", system-ui;
            font-weight: 500;
            font-style: italic;
        }

        .poppins-semibold-italic {
            font-family: "Poppins", system-ui;
            font-weight: 600;
            font-style: italic;
        }

        .poppins-bold-italic {
            font-family: "Poppins", system-ui;
            font-weight: 700;
            font-style: italic;
        }

        .poppins-extrabold-italic {
            font-family: "Poppins", system-ui;
            font-weight: 800;
            font-style: italic;
        }

        .poppins-black-italic {
            font-family: "Poppins", system-ui;
            font-weight: 900;
            font-style: italic;
        }

        body {
            animation: fadeIn 2s ease 0s 1 normal both;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url({{ asset('assets/images/review/bg.jpg') }});
            background-size: cover;
            /* Ensures the image covers the entire area but maintains aspect ratio */
            background-position: center;
            /* Centers the background image */
            background-repeat: no-repeat;
            /* Prevents the background from repeating */
            min-height: 100vh;
            /* Makes sure body takes at least full viewport height */
        }

        .container {
            height: 100vh;
            display: grid;
            place-items: center;
        }

        .container>.envelope-wrapper {
            background: var(--bg-envelope-color);
            box-shadow: 0 0 40px var(--shadow-color);
        }

        .envelope-wrapper>.envelope {
            position: relative;
            width: 350px;
            height: 250px;
        }

        .envelope-wrapper>.envelope::before {
            content: "";
            position: absolute;
            top: 0;
            z-index: 2;
            border-top: 130px solid var(--envelope-tab);
            border-right: 175px solid transparent;
            border-left: 175px solid transparent;
            transform-origin: top;
            transition: all 0.5s ease-in-out 0.7s;
        }

        .envelope-wrapper>.envelope::after {
            content: "";
            position: absolute;
            z-index: 2;
            width: 0px;
            height: 0px;
            border-top: 130px solid transparent;
            border-right: 175px solid var(--envelope-cover);
            border-bottom: 120px solid var(--envelope-cover);
            border-left: 175px solid var(--envelope-cover);
        }

        .sincerely {
            text-align: right;
        }

        .envelope>.letter {
            position: absolute;
            right: 20%;
            bottom: 0;
            width: 54%;
            height: 80%;
            background: var(--primary);
            text-align: center;
            transition: all 1s ease-in-out;
            box-shadow: 0 0 5px var(--shadow-color);
            padding: 20px 10px;
        }

        .envelope>.letter>.text {
            /* font-family: "Caveat", cursive; */
            font-style: normal;
            color: var(--txt-color);
            text-align: justify;
            font-size: 11px;
            padding-right: 2px;
        }

        .text strong {
            font-size: 12px;
        }

        .heart {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 15px;
            height: 15px;
            background: var(--heart-color);
            z-index: 4;
            transform: translate(-50%, -20%) rotate(45deg);
            transition: transform 0.5s ease-in-out 1s;
            box-shadow: 0 1px 6px var(--shadow-color);
            cursor: pointer;
        }

        .heart:before,
        .heart:after {
            content: "";
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: var(--heart-color);
            border-radius: 50%;
        }

        .heart:before {
            top: -7.5px;
        }

        .heart:after {
            right: 7.5px;
        }

        .flap>.envelope:before {
            transform: rotateX(180deg);
            z-index: 0;
        }

        .flap>.envelope>.letter {
            bottom: 200px;
            transform: scale(1.5);
            transition-delay: 1s;
        }

        .flap>.heart {
            transform: rotate(90deg);
            transition-delay: 0.4s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: rotateX(100deg);
                transform-origin: bottom;
            }

            100% {
                opacity: 1;
                transform: rotateX(0);
                transform-origin: bottom;
            }
        }
    </style>
</head>

<body>
    <div class='container'>
        <div class='envelope-wrapper'>
            <div class='envelope'>
                <div class='letter'>
                    <div class='text'>
                        <strong class="poppins-black">
                            Dear {{ $cust[0]->customer->name }},
                        </strong>
                        <p class="poppins-regular">
                            Thank you for leaving your review. We use the reviews you gave us to better us in the future.
                        </p>
                        <p class='sincerely'>
                            Sincerely, <br><img style="width: 30%" src="{{ asset('assets/images/logos/logo.png') }}" alt="" srcset=""> </p>
                    </div>
                </div>
            </div>
            <div class='heart'></div>
        </div>
    </div>

    <script>
        const envelope = document.querySelector('.envelope-wrapper');
        envelope.addEventListener('click', () => {
            envelope.classList.toggle('flap');
        });
    </script>
</body>

</html>

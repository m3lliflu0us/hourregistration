<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="general/general.css">
    <link rel="stylesheet" href="../user/user.css">
    <title>Login | A3</title>
</head>

<body>
    <div class="main">
        <div class="box-wrapper">
            <div class="left">
                <div class="logo">
                    <svg class="svg" width="300" height="94" viewBox="0 0 300 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.8552 42.5285C22.9549 42.5285 28.2424 35.1853 28.2424 27.4638C28.2821 24.2603 27.3815 21.1154 25.6521 18.4184C26.5366 18.1792 27.3381 17.7008 27.9684 17.0356C28.5987 16.3705 29.0334 15.5445 29.2247 14.6483C29.4159 13.7522 29.3564 12.8207 29.0527 11.9562C28.749 11.0916 28.2127 10.3276 27.5029 9.74808C26.7932 9.16854 25.9373 8.79592 25.0295 8.6712C24.1218 8.54647 23.1972 8.67447 22.3574 9.04111C21.5176 9.40775 20.7952 9.99884 20.2695 10.7494C19.7439 11.5 19.4354 12.3809 19.3779 13.2954C17.7035 12.6415 15.9208 12.3095 14.1233 12.3169C5.6371 12.3169 0.00427592 19.0352 0.00427592 27.4638C-0.0450591 29.63 0.358843 31.7825 1.19008 33.7834C2.02132 35.7844 3.26155 37.5895 4.83123 39.083C3.4056 40.051 2.25141 41.3677 1.47847 42.9078C0.705536 44.4479 0.339579 46.1602 0.41543 47.8817C0.41543 54.8056 6.31961 59.8546 13.8355 59.8546C21.6721 59.8546 27.3625 54.5918 27.3625 49.4359C27.2913 48.3912 26.8392 47.4089 26.092 46.6754C25.3448 45.9418 24.3544 45.5079 23.3085 45.4559C18.6378 45.4559 19.7644 51.4752 13.7533 51.4752C13.167 51.4657 12.5884 51.3396 12.0514 51.1041C11.5144 50.8686 11.0297 50.5285 10.6255 50.1037C10.2213 49.6788 9.90582 49.1778 9.69738 48.6297C9.48895 48.0816 9.39176 47.4975 9.41149 46.9114C9.43616 43.6386 12.0593 42.5779 14.8552 42.5285ZM8.40005 27.4638C8.40005 23.599 10.4394 20.3755 14.1562 20.3755C17.8731 20.3755 19.9124 23.599 19.9124 27.4638C19.9124 31.3287 17.8731 34.5521 14.1562 34.5521C10.4394 34.5521 8.40005 31.3204 8.40005 27.4638Z" fill="#DE006A" />
                        <path d="M32.1477 17.226C32.1226 16.6602 32.2124 16.0952 32.4116 15.565C32.6109 15.0348 32.9154 14.5505 33.307 14.1413C33.6985 13.732 34.1688 13.4063 34.6896 13.1838C35.2105 12.9613 35.771 12.8466 36.3373 12.8466C36.9037 12.8466 37.4642 12.9613 37.985 13.1838C38.5058 13.4063 38.9762 13.732 39.3677 14.1413C39.7592 14.5505 40.0638 15.0348 40.263 15.565C40.4623 16.0952 40.5521 16.6602 40.527 17.226V37.7837C40.5521 38.3495 40.4623 38.9146 40.263 39.4447C40.0638 39.9749 39.7592 40.4592 39.3677 40.8684C38.9762 41.2777 38.5058 41.6034 37.985 41.8259C37.4642 42.0484 36.9037 42.1632 36.3373 42.1632C35.771 42.1632 35.2105 42.0484 34.6896 41.8259C34.1688 41.6034 33.6985 41.2777 33.307 40.8684C32.9154 40.4592 32.6109 39.9749 32.4116 39.4447C32.2124 38.9146 32.1226 38.3495 32.1477 37.7837V17.226Z" fill="#DE006A" />
                        <path d="M44.08 4.75987C44.055 4.19405 44.1448 3.62903 44.344 3.09887C44.5432 2.5687 44.8478 2.08439 45.2393 1.67514C45.6308 1.26589 46.1012 0.940188 46.622 0.71767C47.1428 0.495151 47.7033 0.380432 48.2697 0.380432C48.8361 0.380432 49.3966 0.495151 49.9174 0.71767C50.4382 0.940188 50.9086 1.26589 51.3001 1.67514C51.6916 2.08439 51.9962 2.5687 52.1954 3.09887C52.3946 3.62903 52.4844 4.19405 52.4594 4.75987V37.7509C52.4844 38.3167 52.3946 38.8817 52.1954 39.4119C51.9962 39.9421 51.6916 40.4264 51.3001 40.8356C50.9086 41.2449 50.4382 41.5706 49.9174 41.7931C49.3966 42.0156 48.8361 42.1303 48.2697 42.1303C47.7033 42.1303 47.1428 42.0156 46.622 41.7931C46.1012 41.5706 45.6308 41.2449 45.2393 40.8356C44.8478 40.4264 44.5432 39.9421 44.344 39.4119C44.1448 38.8817 44.055 38.3167 44.08 37.7509V4.75987Z" fill="#DE006A" />
                        <path d="M83.3367 37.7509C83.3613 38.3155 83.2708 38.8792 83.0707 39.4078C82.8706 39.9363 82.5652 40.4187 82.173 40.8255C81.7807 41.2324 81.3099 41.5552 80.789 41.7745C80.2681 41.9937 79.7081 42.1048 79.143 42.1009C78.2982 42.0839 77.4769 41.8203 76.78 41.3426C76.0831 40.8648 75.541 40.1938 75.2205 39.412C73.3375 41.7227 71.1912 42.6354 68.0253 42.6354C60.715 42.6354 55.074 35.9172 55.074 27.4803C55.074 19.0434 60.715 12.3251 68.0253 12.3251C70.5543 12.1858 73.0388 13.0317 74.9574 14.6851V4.75987C74.9323 4.19406 75.0221 3.62903 75.2214 3.09887C75.4206 2.5687 75.7252 2.08439 76.1167 1.67514C76.5082 1.26589 76.9786 0.940188 77.4994 0.71767C78.0202 0.495151 78.5807 0.380432 79.1471 0.380432C79.7134 0.380432 80.2739 0.495151 80.7948 0.71767C81.3156 0.940188 81.7859 1.26589 82.1775 1.67514C82.569 2.08439 82.8735 2.5687 83.0728 3.09887C83.272 3.62903 83.3618 4.19406 83.3367 4.75987V37.7509ZM63.4122 27.4885C63.4122 31.3533 65.4597 34.5768 69.1684 34.5768C72.877 34.5768 74.9245 31.3533 74.9245 27.4885C74.9245 23.6236 72.8852 20.392 69.1684 20.392C65.4515 20.392 63.4122 23.6236 63.4122 27.4885Z" fill="#DE006A" />
                        <path d="M94.8984 30.235C94.8984 32.0112 96.2388 34.9057 101.617 34.9057C105.728 34.9057 108.277 32.2743 110.21 32.2743C110.679 32.2718 111.143 32.364 111.575 32.5455C112.007 32.727 112.398 32.994 112.725 33.3304C113.051 33.6668 113.306 34.0657 113.475 34.5031C113.643 34.9406 113.721 35.4076 113.705 35.876C113.705 39.9876 106.879 42.6436 100.548 42.6436C91.5023 42.6436 85.8777 35.9254 85.8777 27.4885C85.8777 19.4298 91.9463 12.3333 100.548 12.3333C108.82 12.3333 114.14 19.2654 114.14 26.5675C114.14 29.5196 112.743 30.2185 110.029 30.2185L94.8984 30.235ZM105.753 24.4788C105.646 23.1124 105.028 21.8364 104.022 20.9057C103.016 19.9749 101.696 19.458 100.326 19.458C98.9551 19.458 97.635 19.9749 96.6289 20.9057C95.6228 21.8364 95.0049 23.1124 94.8984 24.4788H105.753Z" fill="#DE006A" />
                        <path d="M150.773 37.3704C150.798 37.935 150.707 38.4987 150.507 39.0273C150.307 39.5558 150.002 40.0382 149.609 40.445C149.217 40.8519 148.746 41.1747 148.226 41.394C147.705 41.6132 147.145 41.7243 146.579 41.7204C145.735 41.7034 144.913 41.4398 144.216 40.9621C143.52 40.4843 142.978 39.8133 142.657 39.0315C140.774 41.3422 138.628 42.2549 135.462 42.2549C128.152 42.2549 122.51 35.5367 122.51 27.0998C122.51 18.6629 128.152 11.9446 135.462 11.9446C137.991 11.8053 140.475 12.6512 142.394 14.3046V4.37937C142.369 3.81356 142.459 3.24854 142.658 2.71837C142.857 2.18821 143.162 1.7039 143.553 1.29465C143.945 0.8854 144.415 0.559695 144.936 0.337177C145.457 0.114658 146.017 -6.10352e-05 146.584 -6.10352e-05C147.15 -6.10352e-05 147.71 0.114658 148.231 0.337177C148.752 0.559695 149.222 0.8854 149.614 1.29465C150.005 1.7039 150.31 2.18821 150.509 2.71837C150.709 3.24854 150.798 3.81356 150.773 4.37937V37.3704ZM130.849 27.108C130.849 30.9729 132.896 34.1963 136.605 34.1963C140.313 34.1963 142.361 30.9729 142.361 27.108C142.361 23.2431 140.322 20.0115 136.605 20.0115C132.888 20.0115 130.849 23.2431 130.849 27.108Z" fill="#13355b" />
                        <path d="M162.335 29.8545C162.335 31.6307 163.675 34.5253 169.053 34.5253C173.165 34.5253 175.714 31.8939 177.646 31.8939C178.115 31.8914 178.579 31.9836 179.011 32.1651C179.444 32.3466 179.835 32.6135 180.161 32.9499C180.487 33.2863 180.743 33.6853 180.911 34.1227C181.079 34.5602 181.158 35.0271 181.141 35.4956C181.141 39.6071 174.316 42.2632 167.984 42.2632C158.939 42.2632 153.314 35.5449 153.314 27.108C153.314 19.0494 159.383 11.9529 167.984 11.9529C176.256 11.9529 181.577 18.8849 181.577 26.187C181.577 29.1391 180.179 29.8381 177.465 29.8381L162.335 29.8545ZM173.189 24.0984C173.083 22.732 172.465 21.456 171.459 20.5252C170.453 19.5945 169.132 19.0775 167.762 19.0775C166.391 19.0775 165.071 19.5945 164.065 20.5252C163.059 21.456 162.441 22.732 162.335 24.0984H173.189Z" fill="#13355b" />
                        <path d="M185.668 15.9796L196.334 38.0468L206.594 15.9796" stroke="#13355b" stroke-width="8.37031" stroke-linecap="round" stroke-linejoin="round" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M231.751 42.2319C239.802 42.1391 245.87 34.9307 245.87 27.2092C245.91 24.0056 245.009 20.8607 243.28 18.1638C240.985 15.3662 239.606 14.2834 237.006 13.0408C235.331 12.3869 233.549 12.0549 231.751 12.0623C223.265 12.0623 217.632 18.7805 217.632 27.2092C217.583 29.3753 217.987 31.5279 218.818 33.5288C219.649 35.5297 220.584 37.1584 222.459 38.8284C225.345 41.3986 227.985 42.2753 231.751 42.2319ZM231.784 20.1209C228.067 20.1209 226.028 23.3443 226.028 27.2092C226.028 31.0658 228.067 34.2975 231.784 34.2975C235.501 34.2975 237.54 31.074 237.54 27.2092C237.54 23.3443 235.501 20.1209 231.784 20.1209Z" fill="#13355b" />
                        <path d="M248.45 16.679C248.425 16.1144 248.516 15.5507 248.716 15.0222C248.916 14.4936 249.221 14.0113 249.614 13.6044C250.006 13.1976 250.477 12.8747 250.998 12.6554C251.519 12.4362 252.079 12.3251 252.644 12.329C253.488 12.346 254.31 12.6096 255.007 13.0874C255.704 13.5651 256.246 14.2362 256.566 15.018C258.449 12.7073 260.595 11.7945 263.761 11.7945C271.072 11.7945 276.713 18.5128 276.713 26.9497C276.713 35.3866 271.072 42.1048 263.761 42.1048C261.232 42.2441 258.748 41.3982 256.829 39.7448V49.6701C256.854 50.2359 256.764 50.8009 256.565 51.3311C256.366 51.8612 256.061 52.3455 255.67 52.7548C255.278 53.164 254.808 53.4897 254.287 53.7123C253.766 53.9348 253.206 54.0495 252.64 54.0495C252.073 54.0495 251.513 53.9348 250.992 53.7123C250.471 53.4897 250.001 53.164 249.609 52.7548C249.218 52.3455 248.913 51.8612 248.714 51.3311C248.515 50.8009 248.425 50.2359 248.45 49.6701V16.679ZM268.374 26.9414C268.374 23.0766 266.327 19.8531 262.618 19.8531C258.91 19.8531 256.862 23.0766 256.862 26.9414C256.862 30.8063 258.901 34.038 262.618 34.038C266.335 34.038 268.374 30.8063 268.374 26.9414Z" fill="#13355b" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M287.541 11.852C290.973 11.5803 294.184 12.2724 297.175 13.9282C298.855 15.1552 299.547 16.7885 299.251 18.8281C298.53 20.8089 297.118 21.6117 295.016 21.2365C294.482 21.116 292.009 19.7844 291.029 19.5755C289.482 19.1716 288.567 19.1273 288.039 19.4094C286.744 20.1029 286.502 21.3333 287.873 22.3991C288.624 22.9826 292.152 24.2682 294.351 25.0567C299.141 27.1337 300.885 30.7048 299.583 35.77C298.695 38.3191 297.006 40.1184 294.517 41.1681C289.638 42.9035 284.932 42.5158 280.399 40.0054C277.946 38.3038 277.433 35.7166 278.987 33.6107C279.644 32.7203 281.254 32.1565 282.724 32.5311C284.4 33.1008 286.23 34.0625 288.039 34.6903C289.346 35.1437 291.029 34.5996 291.361 34.3581C292.39 33.6107 292.39 32.1496 291.029 31.5345C288.469 30.515 285.922 29.4631 283.389 28.3786C279.705 26.6308 278.238 23.7241 278.987 19.6585C279.808 16.6238 281.182 14.5742 283.959 13.1244C284.914 12.5947 286.683 11.9848 287.541 11.852Z" fill="#13355b" />
                        <path d="M123.739 78.7555L127.212 78.2094C127.407 79.6008 127.946 80.6672 128.831 81.4084C129.728 82.1497 130.976 82.5203 132.576 82.5203C134.188 82.5203 135.385 82.1952 136.165 81.545C136.945 80.8817 137.335 80.108 137.335 79.2237C137.335 78.4304 136.991 77.8062 136.302 77.3511C135.82 77.039 134.624 76.6423 132.712 76.1612C130.138 75.511 128.349 74.9518 127.348 74.4836C126.36 74.0025 125.606 73.3458 125.085 72.5135C124.578 71.6682 124.325 70.7384 124.325 69.7241C124.325 68.8008 124.533 67.949 124.949 67.1687C125.378 66.3755 125.957 65.7187 126.685 65.1986C127.231 64.7954 127.972 64.4573 128.909 64.1842C129.858 63.8981 130.872 63.7551 131.952 63.7551C133.577 63.7551 135.001 63.9892 136.224 64.4573C137.459 64.9255 138.369 65.5627 138.954 66.369C139.54 67.1622 139.943 68.2286 140.164 69.568L136.731 70.0362C136.575 68.9698 136.119 68.1375 135.365 67.5393C134.624 66.9411 133.571 66.642 132.205 66.642C130.593 66.642 129.442 66.9086 128.753 67.4418C128.063 67.975 127.719 68.5992 127.719 69.3144C127.719 69.7696 127.862 70.1792 128.148 70.5433C128.434 70.9205 128.883 71.2326 129.494 71.4796C129.845 71.6097 130.879 71.9088 132.595 72.3769C135.079 73.0402 136.809 73.5863 137.784 74.0155C138.772 74.4316 139.546 75.0428 140.105 75.8491C140.664 76.6554 140.944 77.6567 140.944 78.8531C140.944 80.0235 140.599 81.1288 139.91 82.1692C139.234 83.1965 138.252 83.9963 136.965 84.5685C135.677 85.1276 134.221 85.4072 132.595 85.4072C129.903 85.4072 127.849 84.8481 126.431 83.7297C125.027 82.6113 124.13 80.9533 123.739 78.7555ZM146.208 74.5812C146.208 70.7449 147.275 67.9035 149.408 66.0569C151.189 64.5223 153.361 63.7551 155.923 63.7551C158.771 63.7551 161.098 64.6914 162.906 66.564C164.714 68.4236 165.617 70.9985 165.617 74.2886C165.617 76.9545 165.214 79.0546 164.408 80.5892C163.615 82.1107 162.451 83.294 160.916 84.1393C159.395 84.9846 157.73 85.4072 155.923 85.4072C153.023 85.4072 150.675 84.4774 148.881 82.6178C147.099 80.7582 146.208 78.0793 146.208 74.5812ZM149.817 74.5812C149.817 77.234 150.396 79.2237 151.553 80.5501C152.711 81.8636 154.167 82.5203 155.923 82.5203C157.665 82.5203 159.115 81.8571 160.273 80.5306C161.43 79.2042 162.009 77.182 162.009 74.4641C162.009 71.9023 161.424 69.9646 160.253 68.6512C159.096 67.3248 157.652 66.6616 155.923 66.6616C154.167 66.6616 152.711 67.3183 151.553 68.6317C150.396 69.9451 149.817 71.9283 149.817 74.5812ZM172.072 84.9391V56.3426H175.583V84.9391H172.072ZM197.018 84.9391V81.8961C195.406 84.2369 193.214 85.4072 190.444 85.4072C189.222 85.4072 188.078 85.1732 187.011 84.705C185.958 84.2369 185.171 83.6517 184.651 82.9494C184.144 82.2342 183.786 81.3629 183.578 80.3356C183.435 79.6463 183.364 78.554 183.364 77.0585V64.2232H186.875V75.7125C186.875 77.5461 186.946 78.7816 187.089 79.4188C187.31 80.3421 187.779 81.0703 188.494 81.6035C189.209 82.1237 190.093 82.3837 191.147 82.3837C192.2 82.3837 193.188 82.1172 194.112 81.584C195.035 81.0378 195.685 80.3031 196.062 79.3798C196.452 78.4434 196.647 77.091 196.647 75.3224V64.2232H200.159V84.9391H197.018ZM215.742 81.7986L216.249 84.9001C215.261 85.1081 214.376 85.2122 213.596 85.2122C212.322 85.2122 211.333 85.0106 210.631 84.6075C209.929 84.2043 209.435 83.6777 209.149 83.0275C208.863 82.3642 208.72 80.9793 208.72 78.8726V66.9541H206.145V64.2232H208.72V59.0931L212.211 56.9864V64.2232H215.742V66.9541H212.211V79.0676C212.211 80.069 212.27 80.7127 212.387 80.9988C212.517 81.2849 212.718 81.5125 212.992 81.6815C213.278 81.8506 213.681 81.9351 214.201 81.9351C214.591 81.9351 215.105 81.8896 215.742 81.7986ZM221.611 60.3805V56.3426H225.122V60.3805H221.611ZM221.611 84.9391V64.2232H225.122V84.9391H221.611ZM231.576 74.5812C231.576 70.7449 232.643 67.9035 234.776 66.0569C236.557 64.5223 238.729 63.7551 241.291 63.7551C244.139 63.7551 246.466 64.6914 248.274 66.564C250.082 68.4236 250.985 70.9985 250.985 74.2886C250.985 76.9545 250.582 79.0546 249.776 80.5892C248.983 82.1107 247.819 83.294 246.284 84.1393C244.763 84.9846 243.098 85.4072 241.291 85.4072C238.391 85.4072 236.043 84.4774 234.249 82.6178C232.467 80.7582 231.576 78.0793 231.576 74.5812ZM235.185 74.5812C235.185 77.234 235.764 79.2237 236.921 80.5501C238.079 81.8636 239.535 82.5203 241.291 82.5203C243.033 82.5203 244.483 81.8571 245.641 80.5306C246.798 79.2042 247.377 77.182 247.377 74.4641C247.377 71.9023 246.791 69.9646 245.621 68.6512C244.464 67.3248 243.02 66.6616 241.291 66.6616C239.535 66.6616 238.079 67.3183 236.921 68.6317C235.764 69.9451 235.185 71.9283 235.185 74.5812ZM257.518 84.9391V64.2232H260.678V67.1687C262.199 64.893 264.397 63.7551 267.271 63.7551C268.519 63.7551 269.664 63.9827 270.704 64.4378C271.757 64.88 272.544 65.4652 273.064 66.1934C273.584 66.9216 273.949 67.7864 274.157 68.7878C274.287 69.438 274.352 70.5758 274.352 72.2014V84.9391H270.841V72.3379C270.841 70.9075 270.704 69.8411 270.431 69.1389C270.158 68.4236 269.67 67.8579 268.968 67.4418C268.279 67.0127 267.466 66.7981 266.53 66.7981C265.034 66.7981 263.74 67.2728 262.648 68.2221C261.569 69.1714 261.029 70.9725 261.029 73.6254V84.9391H257.518ZM280.748 78.7555L284.22 78.2094C284.415 79.6008 284.954 80.6672 285.839 81.4084C286.736 82.1497 287.984 82.5203 289.584 82.5203C291.196 82.5203 292.393 82.1952 293.173 81.545C293.953 80.8817 294.344 80.108 294.344 79.2237C294.344 78.4304 293.999 77.8062 293.31 77.3511C292.829 77.039 291.632 76.6423 289.72 76.1612C287.146 75.511 285.358 74.9518 284.356 74.4836C283.368 74.0025 282.614 73.3458 282.093 72.5135C281.586 71.6682 281.333 70.7384 281.333 69.7241C281.333 68.8008 281.541 67.949 281.957 67.1687C282.386 66.3755 282.965 65.7187 283.693 65.1986C284.239 64.7954 284.98 64.4573 285.917 64.1842C286.866 63.8981 287.88 63.7551 288.96 63.7551C290.585 63.7551 292.009 63.9892 293.232 64.4573C294.467 64.9255 295.377 65.5627 295.963 66.369C296.548 67.1622 296.951 68.2286 297.172 69.568L293.739 70.0362C293.583 68.9698 293.128 68.1375 292.373 67.5393C291.632 66.9411 290.579 66.642 289.213 66.642C287.601 66.642 286.45 66.9086 285.761 67.4418C285.071 67.975 284.727 68.5992 284.727 69.3144C284.727 69.7696 284.87 70.1792 285.156 70.5433C285.442 70.9205 285.891 71.2326 286.502 71.4796C286.853 71.6097 287.887 71.9088 289.603 72.3769C292.087 73.0402 293.817 73.5863 294.792 74.0155C295.78 74.4316 296.554 75.0428 297.113 75.8491C297.673 76.6554 297.952 77.6567 297.952 78.8531C297.952 80.0235 297.608 81.1288 296.918 82.1692C296.242 83.1965 295.26 83.9963 293.973 84.5685C292.685 85.1276 291.229 85.4072 289.603 85.4072C286.912 85.4072 284.857 84.8481 283.439 83.7297C282.035 82.6113 281.138 80.9533 280.748 78.7555Z" fill="#DE006A" />
                    </svg>

                </div>
                <div class="inf">
                    <span>
                        Inloggen
                    </span>
                </div>
                <div class="ins">
                    <span>
                        Log in met uw account
                    </span>
                </div>
            </div>

            <div class="right">
                <form action="../userincludes/login.inc.php" method="POST">
                    <div class="email">
                        <input type="text" name="email" value="" onkeyup="this.setAttribute('value', this.value);">
                        <label for="email">E-mailadres</label>
                    </div>
                    <div class="password">
                        <input type="password" name="pwd" value="" id="pwd" onkeyup="this.setAttribute('value', this.value);">
                        <label for="password">Wachtwoord</label>
                    </div>
                    <div class="error-container ">
                        <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "emptyfields") {
                                echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                echo "<span style='color: #b3261e;font-size: 12px'>Please fill in all fields</span>";
                            } else if ($_GET["error"] == "incorrectlogin") {
                                echo '<img style="height: 16px; margin: 0 5px 0 0;" src="../img/error.svg">';
                                echo "<span style='color: #b3261e;font-size: 12px'>Incorrect email or password, please try again</span>";
                            }
                        }
                        ?>
                    </div>

                        <label class="checkbox-container">
                            Wachtwoord tonen
                                <input type="checkbox" onclick="togglePwd()">

                                <span class="checkmark"></span>

                        </label>

                    <div class="bottom">
                        <div class="forgot">
                            <a href="">
                                <span>
                                    Wachtwoord vergeten?
                                </span>
                            </a>
                        </div>

                        <div class="submit">
                            <input type="submit" name="submit" value="Log in">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function togglePwd() {
        var x = document.getElementById("pwd");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
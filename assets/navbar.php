<html lang="en">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

<body>
    <main>
        <div class="input-wrapper">
            <div class="input-content">
                <div class="inf">
                    <span>
                        Verander uw wachtwoord
                    </span>
                </div>
            </div>
            <form action="<?= BASE_URL ?>userincludes/changepwd.inc.php" method="POST">
                <div class="password">
                    <input type="password" name="Pwd" id="oldPwd" value="" onkeyup="this.setAttribute('value', this.value);">
                    <label for="Pwd">wachtwoord</label>
                </div>
                <div class="password">
                    <input type="password" name="newPwd" id="newPwd" value="" onkeyup="this.setAttribute('value', this.value);">
                    <label for="newPwd">Nieuw wachtwoord</label>
                </div>

                <div class="password">
                    <input type="password" name="confNewPwd" id="confirmNewPwd" value="" onkeyup="this.setAttribute('value', this.value);">
                    <label for="confNewPwd">Herhaal nieuw wachtwoord</label>
                </div>
                <label class="checkbox-container">
                    <span>
                        Wachtwoord(en) tonen
                    </span>
                    <input type="checkbox" onclick="toggleoldPwd(), togglenewPwd(), toggleconfnewPwd()">

                    <span class="checkmark"></span>

                </label>
                <div class="bottom">
                    <div class="submit">
                        <input type="submit" name="submit" value="Log in">
                    </div>
                </div>
            </form>
        </div>

        <div class="navbar-wrapper">
            <div class="navbar-item">
                <a href="<?= BASE_URL ?>">
                    <img src="<?= IMG_URL ?>logo.svg" alt="">
                </a>
            </div>
            <div class="navbar-item">
                <a class="" href="<?= BASE_URL ?>">
                    <svg class="svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="4" width="6" height="7" rx="1" stroke="#ffffff" stroke-linejoin="round" />
                        <rect x="4" y="15" width="6" height="5" rx="1" stroke="#ffffff" stroke-linejoin="round" />
                        <rect x="14" y="4" width="6" height="5" rx="1" stroke="#ffffff" stroke-linejoin="round" />
                        <rect x="14" y="13" width="6" height="7" rx="1" stroke="#ffffff" stroke-linejoin="round" />
                    </svg>
                    <span class="hover">
                        Dashboard
                    </span>
                </a>
            </div>

            <div class="navbar-item">
                <a class="" href="<?= BASE_URL ?>assignment/">
                    <svg class="svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="8.5" stroke="#ffffff" />
                        <path d="M16.5 12H12.25C12.1119 12 12 11.8881 12 11.75V8.5" stroke="#ffffff" stroke-linecap="round" />
                    </svg>
                    <span class="hover">
                        Opdrachten
                    </span>
                </a>
            </div>

            <?php
            if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == 'administrator') {
                echo '
            <div class="navbar-item">
                <a class="hover" href="' . BASE_URL . 'employee/">
                    <svg class="svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="8" r="2.5" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M13.7679 6.5C13.9657 6.15743 14.2607 5.88121 14.6154 5.70625C14.9702 5.5313 15.3689 5.46548 15.7611 5.51711C16.1532 5.56874 16.5213 5.73551 16.8187 5.99632C17.1161 6.25713 17.3295 6.60028 17.4319 6.98236C17.5342 7.36445 17.521 7.76831 17.3939 8.14288C17.2667 8.51745 17.0313 8.8459 16.7175 9.08671C16.4037 9.32751 16.0255 9.46985 15.6308 9.49572C15.2361 9.52159 14.8426 9.42983 14.5 9.23205" stroke="#ffffff" />
                        <path d="M10.2321 6.5C10.0343 6.15743 9.73935 5.88121 9.38458 5.70625C9.02981 5.5313 8.63113 5.46548 8.23895 5.51711C7.84677 5.56874 7.47871 5.73551 7.18131 5.99632C6.88391 6.25713 6.67053 6.60028 6.56815 6.98236C6.46577 7.36445 6.47899 7.76831 6.60614 8.14288C6.73329 8.51745 6.96866 8.8459 7.28248 9.08671C7.5963 9.32751 7.97448 9.46985 8.36919 9.49572C8.76391 9.52159 9.15743 9.42983 9.5 9.23205" stroke="#ffffff" />
                        <path d="M12 12.5C16.0802 12.5 17.1335 15.8022 17.4054 17.507C17.4924 18.0524 17.0523 18.5 16.5 18.5H7.5C6.94771 18.5 6.50763 18.0524 6.59461 17.507C6.86649 15.8022 7.91976 12.5 12 12.5Z" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M19.2965 15.4162L18.8115 15.5377L19.2965 15.4162ZM13.0871 12.5859L12.7179 12.2488L12.0974 12.9283L13.0051 13.0791L13.0871 12.5859ZM17.1813 16.5L16.701 16.639L16.8055 17H17.1813V16.5ZM15.5 12C16.5277 12 17.2495 12.5027 17.7783 13.2069C18.3177 13.9253 18.6344 14.8306 18.8115 15.5377L19.7816 15.2948C19.5904 14.5315 19.2329 13.4787 18.578 12.6065C17.9126 11.7203 16.9202 11 15.5 11V12ZM13.4563 12.923C13.9567 12.375 14.6107 12 15.5 12V11C14.2828 11 13.3736 11.5306 12.7179 12.2488L13.4563 12.923ZM13.0051 13.0791C15.3056 13.4614 16.2789 15.1801 16.701 16.639L17.6616 16.361C17.1905 14.7326 16.019 12.5663 13.1691 12.0927L13.0051 13.0791ZM18.395 16H17.1813V17H18.395V16ZM18.8115 15.5377C18.8653 15.7526 18.7075 16 18.395 16V17C19.2657 17 20.0152 16.2277 19.7816 15.2948L18.8115 15.5377Z" fill="#ffffff" />
                        <path d="M10.9129 12.5859L10.9949 13.0791L11.9026 12.9283L11.2821 12.2488L10.9129 12.5859ZM4.70343 15.4162L5.18845 15.5377L4.70343 15.4162ZM6.81868 16.5V17H7.19453L7.29898 16.639L6.81868 16.5ZM8.49999 12C9.38931 12 10.0433 12.375 10.5436 12.923L11.2821 12.2488C10.6264 11.5306 9.71723 11 8.49999 11V12ZM5.18845 15.5377C5.36554 14.8306 5.68228 13.9253 6.22167 13.2069C6.75048 12.5027 7.47226 12 8.49999 12V11C7.0798 11 6.08743 11.7203 5.42199 12.6065C4.76713 13.4787 4.40955 14.5315 4.21841 15.2948L5.18845 15.5377ZM5.60498 16C5.29247 16 5.13465 15.7526 5.18845 15.5377L4.21841 15.2948C3.98477 16.2277 4.73424 17 5.60498 17V16ZM6.81868 16H5.60498V17H6.81868V16ZM7.29898 16.639C7.72104 15.1801 8.69435 13.4614 10.9949 13.0791L10.8309 12.0927C7.98101 12.5663 6.8095 14.7326 6.33838 16.361L7.29898 16.639Z" fill="#ffffff" />
                    </svg>
                    <span class="hover">
                        Medewerkers
                    </span>
                </a>
            </div>';
            } ?>

            <?php
            if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == 'administrator') {
                echo '
            <div class="navbar-item">
                <a class="hover" href="' . BASE_URL . 'client/">
                    <svg class="svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.5 3.5H17.7C19.4913 3.5 20.387 3.5 20.9435 4.0565C21.5 4.61299 21.5 5.50866 21.5 7.3V7.5" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M17.5 20.5H17.7C19.4913 20.5 20.387 20.5 20.9435 19.9435C21.5 19.387 21.5 18.4913 21.5 16.7V16.5" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M6.5 3.5H6.3C4.50866 3.5 3.61299 3.5 3.0565 4.0565C2.5 4.61299 2.5 5.50866 2.5 7.3V7.5" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M6.5 20.5H6.3C4.50866 20.5 3.61299 20.5 3.0565 19.9435C2.5 19.387 2.5 18.4913 2.5 16.7V16.5" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M7.21484 15.7847C7.68758 15.1024 8.37508 14.5254 9.21678 14.1204C10.0585 13.7155 11.0187 13.5 12 13.5C12.9813 13.5 13.9415 13.7155 14.7832 14.1204C15.6249 14.5254 16.3124 15.1024 16.7852 15.7847" stroke="#ffffff" stroke-linecap="round" />
                        <circle cx="12" cy="9" r="2.5" stroke="#ffffff" stroke-linecap="round" />
                    </svg>
                    <span class="hover">
                        Klanten
                    </span>
                </a>
            </div>';
            } ?>

            <?php
            if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == 'administrator') {
                echo '
            <div class="navbar-item">
                <a class="hover" href="' . BASE_URL . 'activities/">
                    <svg class="svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13V15C19 17.8284 19 19.2426 18.1213 20.1213C17.2426 21 15.8284 21 13 21H11C8.17157 21 6.75736 21 5.87868 20.1213C5 19.2426 5 17.8284 5 15V9C5 6.17157 5 4.75736 5.87868 3.87868C6.75736 3 8.17157 3 11 3H12" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M18 3L18 9" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M21 6L15 6" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M9 13L15 13" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M9 9L13 9" stroke="#ffffff" stroke-linecap="round" />
                        <path d="M9 17L13 17" stroke="#ffffff" stroke-linecap="round" />
                    </svg>
                    <span class="hover">
                        Werkzaamheden
                    </span>
                </a>
            </div>';
            } ?>

            <div class="navbar-item">
                <div class="popover-wrapper">
                    <div class="popover-content">
                        <span class="txt-secondary">
                            <?= $_SESSION["userEmail"]; ?>
                        </span>
                        <div class="divider"></div>
                        <span class="button">Verander wachtwoord</span>
                        <div class="divider"></div>
                        <a href="<?= BASE_URL ?>userincludes/logout.inc.php">Log uit</a>
                    </div>
                </div>
                <svg class="svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.7274 20.4471C19.2716 19.1713 18.2672 18.0439 16.8701 17.2399C15.4729 16.4358 13.7611 16 12 16C10.2389 16 8.52706 16.4358 7.12991 17.2399C5.73276 18.0439 4.72839 19.1713 4.27259 20.4471" stroke="#ffffff" stroke-linecap="round" />
                    <circle cx="12" cy="8" r="4" stroke="#ffffff" stroke-linecap="round" />
                </svg>
                <span class="hover">
                    <?= $_SESSION["userFirstname"]; ?>
                    <?= $_SESSION["userLastnameInitial"]; ?>
                </span>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var popoverWrapper = document.querySelector('.popover-wrapper');
            var navbarItem = document.querySelector('.navbar-item:last-child');

            navbarItem.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the event from bubbling up the DOM tree
                popoverWrapper.style.display = (popoverWrapper.style.display === 'flex') ? 'none' : 'flex';
                this.classList.add('active'); // Add 'active' class when clicked
            });

            document.addEventListener('click', function() {
                popoverWrapper.style.display = 'none';
                navbarItem.classList.remove('active'); // Remove 'active' class when clicked outside
            });

            popoverWrapper.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the popover from closing when clicking within it
            });
        });


        document.addEventListener('DOMContentLoaded', (event) => {
            var inputWrapper = document.querySelector('.input-wrapper');
            var changePwdLink = document.querySelector('span[class="button"]');
            var dashboardWindow = document.querySelector('.dashboard-window');

            changePwdLink.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the event from bubbling up the DOM tree
                inputWrapper.style.display = 'flex';
                // dashboardWindow.style.filter = 'grayscale(100%)'
            });

            document.addEventListener('click', function() {
                inputWrapper.style.display = 'none';
                // dashboardWindow.style.filter = 'grayscale(0%)';
            });

            inputWrapper.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the popover from closing when clicking within it
            });
        });



        function toggleoldPwd() {
            var x = document.getElementById("oldPwd");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function togglenewPwd() {
            var x = document.getElementById("newPwd");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function toggleconfnewPwd() {
            var x = document.getElementById("confirmNewPwd");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>



<style>
    :root {
        user-select: text;
        font-family: "Manrope", sans-serif;
        --shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        --border-radius: 2rem;
        --gilde-primary: #13355b;
        --gilde-primary-hover: #23415f;
        --gilde-secondary: #ca2b69;
        --gilde-secondary-hover: #b3255d;
        --gilde-tertiary-hover: #b3255e12;
        --white-primary: #ffffff;
        --white-secondary: #eeeeee;
        --txt-primary: #ffffff;
        --txt-secondary: #222222;
        --txt-tertiary: #1f1f1f;
        --txt: #00365e;
        --shadow-color: #0000000e;
        --transition-primary: ease-in-out 0.1s;
        --shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072), 0 41.8px 33.4px rgba(0, 0, 0, 0.086), 0 100px 80px rgba(0, 0, 0, 0.12);
    }

    * {
        box-sizing: border-box;
        text-decoration: none;
        color: var(--txt-tertiary);
        font-family: "Manrope", sans-serif;
    }

    *::before {
        box-sizing: inherit;
    }

    *::after {
        box-sizing: inherit;
    }

    body {
        background-color: var(--gilde-primary);
        margin: 0;
        padding: 0;
    }

    .navbar-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        flex-direction: column;
        width: 100%;
        gap: 5%;
        margin: 0 0 0 1rem;
    }

    .button {
        cursor: pointer;
    }

    .txt-secondary {
        color: var(--txt-secondary);
    }

    a {
        color: var(--txt-primary);
    }

    .input-wrapper {
        display: none;
        flex-basis: 50%;
        flex-direction: column;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 20rem;
        width: 20rem;
        background-color: var(--white-primary);
        border-radius: 28px;
        min-height: 500px;
        width: 400px;
        padding: 10px;
        box-shadow: var(--shadow);
    }

    .input-content {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100%;
    }

    .input-content form input {
        color: var(--txt-tertiary);
    }

    .inf {
        margin: 22px 0 0 0;
    }

    .inf span {
        color: var(--txt-secondary);
        font-weight: 450;
        font-size: 22px;
    }

    form {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
    }

    .password input:focus,
    .email input:focus,
    .firstname input:focus,
    .lastname input:focus,
    .password-repeat input:focus {
        outline: none;
        border: 2px solid var(--gilde-secondary);
        margin: 1px 1px 0 0px;
    }

    .email input,
    .password input,
    .firstname input,
    .lastname input,
    .password-repeat input {
        width: 100%;
        height: 52px;
        padding: 13px 15px;
        font-size: 16px;
        margin: 1px 1px 0 1px;
        border-radius: 4px;
        color: var(--txt-tertiary);
        background-color: #ffffff;
        outline: none;
        border: 1px solid var(--txt-tertiary);
    }

    .firstname,
    .lastname,
    .email,
    .password,
    .password-repeat {
        position: relative;
    }

    .lastname,
    .margin,
    .password,
    .password-repeat {
        margin: 24px 0 0 0;
    }

    .firstname label,
    .lastname label,
    .email label,
    .password label,
    .password-repeat label {
        position: absolute;
        top: 0;
        left: 10px;
        margin: 5.5px 0 0 0;
        padding: 0.625rem 0;
        color: var(--txt-tertiary);
        transition: var(--transition-primary);
        cursor: text;
        pointer-events: none;

    }

    .firstname input:focus~label,
    .firstname input:not([value=""])~label {
        top: -0.8rem;
        left: 10px;
        color: var(--gilde-secondary);
        font-size: 0.75rem;
        background-color: #ffffff;
        height: 10px;
        padding: 0 5px;
        cursor: default;
    }

    .lastname input:focus~label,
    .lastname input:not([value=""])~label {
        top: -0.8rem;
        left: 10px;
        color: var(--gilde-secondary);
        font-size: 0.75rem;
        background-color: #ffffff;
        height: 10px;
        padding: 0 5px;
        cursor: default;
    }

    .email input:focus~label,
    .email input:not([value=""])~label {
        top: -0.8rem;
        left: 10px;
        color: var(--gilde-secondary);
        font-size: 0.75rem;
        background-color: #ffffff;
        height: 10px;
        padding: 0 5px;
        cursor: default;
    }

    .password input:focus~label,
    .password input:not([value=""])~label {
        top: -0.8rem;
        left: 10px;
        color: var(--gilde-secondary);
        font-size: 0.75rem;
        background-color: #ffffff;
        height: 10px;
        padding: 0 5px;
        cursor: default;
    }

    .password-repeat input:focus~label,
    .password-repeat input:not([value=""])~label {
        top: -0.8rem;
        left: 10px;
        color: var(--gilde-secondary);
        font-size: 0.75rem;
        background-color: #ffffff;
        height: 10px;
        padding: 0 5px;
        cursor: default;
    }

    .firstname input:not([value=""])~label,
    .lastname input:not([value=""])~label,
    .email input:not([value=""])~label,
    .password input:not([value=""])~label,
    .password-repeat input:not([value=""])~label {
        transition: 0.025 ease;
    }

    .firstname input:not(:focus)~label,
    .lastname input:not(:focus)~label,
    .email input:not(:focus)~label,
    .password input:not(:focus)~label,
    .password-repeat input:not(:focus)~label {
        color: var(--txt-tertiary);
    }

    .error-container {
        display: flex;
        align-items: center;
        padding: 10px 0 10px 0;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        position: relative;
        cursor: pointer;
        height: 48px;
        margin: 20px 0 0 0;
    }


    .checkbox-container input[type="checkbox"] {
        display: none;
    }

    .checkbox-container {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: flex-start;
        padding: 1px 0 0 35px;
        max-width: 50%;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 21.6px;
        width: 21.6px;
        padding: 0 0 2.5px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.08s ease-in-out;
        border-radius: 2.5px;
        border: black solid 1px;
    }

    .checkbox-container input:checked~.checkmark {
        background-color: var(--gilde-secondary);
    }

    .checkbox-container input:checked~.checkmark:after {
        content: "";
        width: 7px;
        height: 12px;
        border: solid var(--txt-primary);
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    .checkbox-container span {
        color: var(--txt-tertiary);
        text-wrap: nowrap;
    }

    .bottom {
        margin: auto 0 0 0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .submit input[type="submit"] {
        border: none;
        outline: none;
        border-radius: 32px;
        font-weight: 600;
        font-size: 16px;
        height: 48px;
        width: 110px;
        color: var(--txt-primary);
        background-color: var(--gilde-secondary);
        transition: var(--transition-primary);
        box-shadow: var();
    }

    .submit:hover input[type="submit"] {
        background-color: var(--gilde-secondary-hover);
        box-shadow: 0 1.8px 2.2px 1.8px var(--shadow-color);
    }

    .navbar-item {
        display: flex;
        align-items: center;
        max-height: 1rem;
    }

    .navbar-item a,
    .navbar-item a span,
    .navbar-item span {
        display: flex;
        align-items: center;
        transition: var(--transition-primary);
        color: var(--txt-primary);
    }

    .hover {
        display: flex;
        align-items: center;
        transition: var(--transition-primary);
    }

    .navbar-item:hover .hover,
    .navbar-item.active .hover {
        color: #cb2b6a;
        padding: 0 0 0 2%;
    }


    .navbar-item:first-child img {
        height: 50px;
    }

    .navbar-item .svg {
        padding: 0 0.6rem 0 0;
        height: 24px;
        transition: var(--transition-primary);
    }

    .navbar-item:hover .svg,
    .navbar-item.active .svg {
        height: 36px;
    }

    .navbar-item .svg rect,
    .navbar-item .svg path,
    .navbar-item .svg circle {
        transition: var(--transition-primary);
    }

    .navbar-item:hover .svg rect,
    .navbar-item:hover .svg path,
    .navbar-item:hover .svg circle,
    .navbar-item.active .svg rect,
    .navbar-item.active .svg path,
    .navbar-item.active .svg circle {
        stroke: #cb2b6a;
    }

    .navbar-item:first-child {
        margin: 0 0 auto 0;
    }

    .navbar-item:last-child {
        margin: auto 0 0 0;
        text-wrap: nowrap;
    }

    .navbar-item:hover {
        cursor: pointer;
    }

    .txt-secondary:hover {
        cursor: text;
    }

    .popover-wrapper:hover {
        cursor: default;
    }

    .popover-wrapper {
        display: none;
        position: absolute;
        width: calc(10% - 30px);
        height: 14%;
        margin: 0 0 14rem 0;
        background-color: var(--gilde-secondary);
        padding: 8px 15px;
        border-radius: 8px;
    }

    .popover-content {
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 10%;
        height: 100%;
        font-size: 14px;
        max-width: 100%;
    }

    .divider {
        height: 1px;
        width: 100%;
        margin: 2% 0;
        background-color: var(--gilde-primary-hover);
    }

    .hover {
        display: flex;
        align-items: center;
        transition: var(--transition-primary);
    }

    .navbar-item:hover .hover {
        color: #cb2b6a;
        padding: 0 0 0 2%;

    }
</style>
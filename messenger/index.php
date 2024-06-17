        <?php
        include("messenger.php");
        include("../config.php");

        $currentPage = 'messenger';
        $currentUserId = $_SESSION["userId"];
        $selectedUserId = isset($_GET['chat']) ? $_GET['chat'] : null;
        $messages = $selectedUserId ? getMessages($currentUserId, $selectedUserId, $conn) : [];
        $employees = getEmployees($conn);

        // Exclude the current user from the list of employees
        $employees = array_filter($employees, function ($employee) use ($currentUserId) {
            return $employee['userId'] != $currentUserId;
        });
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Messenger</title>
            <link rel="stylesheet" href="messenger.css">
            <link rel="stylesheet" href="../assets/layout.css">
            <link rel="stylesheet" href="../assets/navbar.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
        </head>

        <body>
            <main>
                <?php include("../assets/navbar.php"); ?>

                <div class="dashboard-wrapper">
                    <div class="dashboard-window">
                        <div class="messenger-container">
                            <div class="title-wrapper">
                                <span>Messenger</span>
                            </div>

                            <div class="chat-list">
                                <div class="subheading-wrapper">
                                    <span>Chat lijst</span>
                                </div>

                                <div class="employee-wrapper">
                                    <?php foreach ($employees as $employee) : ?>
                                        <div class="employee">
                                            <a href="index.php?chat=<?php echo htmlspecialchars($employee['userId']); ?>">
                                                <div class="left-wrapper">
                                                    <div class="name-wrapper">
                                                        <?php echo htmlspecialchars($employee['userFirstname']) . ' ' . htmlspecialchars($employee['userLastname']); ?>
                                                    </div>
                                                    <div class="email-wrapper">
                                                        <?php echo htmlspecialchars($employee['userEmail']) ?>
                                                    </div>
                                                </div>
                                                <div class="right-wrapper">
                                                    <div class="clock-wrapper">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12" cy="12" r="8.5" stroke="#696969" />
                                                            <path d="M16.5 12H12.25C12.1119 12 12 11.8881 12 11.75V8.5" stroke="#696969" stroke-linecap="round" />
                                                        </svg>
                                                    </div>
                                                    <?php if (isset($employee['last_active'])) : ?>
                                                        <div class="active-wrapper">
                                                            Laatst gezien: <?php echo date('Y-m-d H:i:s', strtotime($employee['last_active'])); ?>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="active-wrapper">
                                                            Laatst gezien: Niet beschikbaar
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="chat-view">
                                <div class="subheading-wrapper">
                                    <span>Chat</span>
                                </div>

                                <div class="message-wrapper">
                                    <?php
                                    $lastDate = null;
                                    foreach ($messages as $message) :
                                        $currentDate = date('Y-m-d', strtotime($message['timestamp']));
                                        if ($lastDate !== $currentDate) {
                                            echo "<div class='date-separator'>" . htmlspecialchars(date('F j, Y', strtotime($message['timestamp']))) . "</div>";
                                            $lastDate = $currentDate;
                                        }
                                        echo "<div class='message-container " . ($message['senderId'] == $currentUserId ? 'sender' : 'recipient') . "'>";
                                        echo "<div class='text-wrapper'><span class='text'>" . htmlspecialchars($message['messageText']) . "</span></div>";
                                        echo "<div class='timestamp-wrapper'><span class='timestamp'>" . htmlspecialchars(date('H:i', strtotime($message['timestamp']))) . "</span></div>";
                                        echo "<div class='message-settings'>";
                                        echo "<button class='settings-button'>⚙️</button>";
                                        echo "  <div class='settings-menu'>";
                                        echo "<ul>";
                                        echo "<li class='edit-message'>Edit</li>";
                                        echo "<li class='delete-message'>Delete for everyone</li>";
                                        echo "</ul>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    endforeach;
                                    ?>
                                </div>

                                <?php if ($selectedUserId && $selectedUserId != $currentUserId) : ?>
                                    <form class="message-bar-wrapper" action="messenger.php" method="POST">
                                        <div class="message-bar">
                                            <input type="hidden" name="recipientId" value="<?php echo htmlspecialchars($selectedUserId); ?>">
                                            <input class="message-bar-label" type="text" name="message" value="" onkeyup="this.setAttribute('value', this.value);">
                                            <label for="message">Send a message...</label>
                                            <button type="submit">
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2978 5.68315C17.9189 5.75055 17.3817 5.92686 16.5215 6.21358L10.0305 8.37724C9.20312 8.65304 8.61936 8.84795 8.19945 9.01179C7.99178 9.09282 7.84715 9.15754 7.74658 9.2106C7.66139 9.25554 7.63077 9.2803 7.62895 9.28156C7.22309 9.67446 7.22309 10.3255 7.62895 10.7184C7.63077 10.7197 7.66139 10.7444 7.74658 10.7894C7.84715 10.8424 7.99178 10.9072 8.19945 10.9882C8.61936 11.152 9.20312 11.3469 10.0305 11.6227C10.0495 11.6291 10.0683 11.6353 10.087 11.6415C10.3604 11.7325 10.6004 11.8123 10.8214 11.9292C11.3539 12.2108 11.7892 12.6461 12.0708 13.1786C12.1877 13.3996 12.2675 13.6396 12.3585 13.913C12.3647 13.9317 12.3709 13.9505 12.3773 13.9695C12.6531 14.7969 12.848 15.3806 13.0118 15.8005C13.0928 16.0082 13.1576 16.1528 13.2106 16.2534C13.2556 16.3386 13.2803 16.3692 13.2816 16.371C13.6745 16.7769 14.3255 16.7769 14.7184 16.371C14.7197 16.3692 14.7444 16.3386 14.7894 16.2534C14.8424 16.1528 14.9072 16.0082 14.9882 15.8005C15.152 15.3806 15.3469 14.7969 15.6227 13.9695L17.7864 7.4785C18.0731 6.61832 18.2494 6.0811 18.3168 5.70219C18.3182 5.6943 18.3196 5.68663 18.3208 5.67916C18.3134 5.68042 18.3057 5.68175 18.2978 5.68315ZM18.5568 5.66004C18.5566 5.66022 18.5533 5.65995 18.5475 5.65868C18.5541 5.65922 18.557 5.65985 18.5568 5.66004ZM18.3413 5.45245C18.34 5.44671 18.3398 5.44343 18.34 5.44322C18.3401 5.44302 18.3408 5.44588 18.3413 5.45245ZM17.9475 3.71406C18.4985 3.61605 19.253 3.58686 19.8331 4.16691C20.4131 4.74697 20.3839 5.50148 20.2859 6.05247C20.1896 6.5939 19.9632 7.27302 19.7077 8.03931L19.6838 8.11095L17.5201 14.6019L17.5107 14.6301C17.2464 15.423 17.0358 16.0549 16.8514 16.5275C16.6781 16.9717 16.4726 17.4321 16.1631 17.7541C14.9827 18.9825 13.0173 18.9825 11.8369 17.7541C11.5274 17.4321 11.3219 16.9717 11.1486 16.5275C10.9642 16.055 10.7536 15.423 10.4893 14.6303L10.4799 14.6019C10.3595 14.2407 10.3324 14.1694 10.3029 14.1136C10.209 13.9361 10.0639 13.791 9.88637 13.6971C9.83055 13.6676 9.75926 13.6405 9.39806 13.5201L9.36973 13.5107C8.57694 13.2464 7.94503 13.0358 7.47249 12.8514C7.0283 12.6781 6.56794 12.4726 6.24589 12.1631C5.01744 10.9826 5.01744 9.01733 6.24589 7.83686C6.56794 7.52738 7.0283 7.32189 7.47249 7.14859C7.94505 6.96421 8.57699 6.75356 9.36981 6.48929L9.39806 6.47988L15.889 4.31622C15.913 4.30823 15.9369 4.30027 15.9607 4.29234C16.727 4.03683 17.4061 3.81038 17.9475 3.71406Z" fill="#ffffff" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                <?php else : ?>
                                    <div class="closed-chat-wrapper">
                                        <span>Kies een medewerker uit de chat lijst.</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <script>
                // Function to toggle the settings menu
                function toggleSettingsMenu(event) {
                    const settingsMenu = event.currentTarget.nextElementSibling;
                    settingsMenu.classList.toggle('active');
                }

                // Function to copy message text
                function copyMessage(event) {
                    const messageText = event.currentTarget.closest('.message-container').querySelector('.text').textContent;
                    navigator.clipboard.writeText(messageText).then(() => {
                        alert('Message copied to clipboard');
                    });
                }

                // Function to delete message
                function deleteMessage(event) {
                    const messageContainer = event.currentTarget.closest('.message-container');
                    messageContainer.remove();
                    // Additional code to handle the deletion on the server side might be needed
                }

                // Function to edit message
                // Function to edit message
                function editMessage(event) {
                    const messageContainer = event.currentTarget.closest('.message-container');
                    const messageTextElement = messageContainer.querySelector('.text');
                    const messageId = messageContainer.dataset.messageId; // Ensure you have a data-message-id attribute on each message container
                    const originalText = messageTextElement.textContent;
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = originalText;
                    input.className = 'edit-input'; // Add a class for styling if needed
                    messageTextElement.replaceWith(input);
                    input.focus();

                    // Save changes on 'Enter' key press
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            const newText = input.value;
                            // Replace input with the new text span
                            const newTextSpan = document.createElement('span');
                            newTextSpan.classList.add('text');
                            newTextSpan.textContent = newText;
                            input.replaceWith(newTextSpan);

                            // Send the new text to the server
                            fetch('path/to/your/edit/message/endpoint', { // Replace with your actual endpoint
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        action: 'editMessage',
                                        messageId: messageId,
                                        newText: newText
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log('Success:', data);
                                })
                                .catch((error) => {
                                    console.error('Error:', error);
                                });
                        }
                    });
                }

                // Function to insert an 'edited' notification in the chat
                function insertEditNotification(messageContainer) {
                    const editNotification = document.createElement('div');
                    editNotification.className = 'edit-notification';
                    editNotification.textContent = 'Message edited';
                    messageContainer.parentNode.insertBefore(editNotification, messageContainer.nextSibling);
                }

                // Modify the editMessage function to call insertEditNotification
                function editMessage(event) {
                    // ... existing editMessage code ...

                    // After saving the new text, insert an 'edited' notification
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            // ... existing code to save the new text ...

                            // Insert an 'edited' notification
                            insertEditNotification(messageContainer);
                        }
                    });
                }


                // Event listeners for settings button
                document.querySelectorAll('.settings-button').forEach(button => {
                    button.addEventListener('click', toggleSettingsMenu);
                });

                // Event listeners for edit, delete, and copy options
                document.querySelectorAll('.edit-message').forEach(option => {
                    option.addEventListener('click', editMessage);
                });

                document.querySelectorAll('.delete-message').forEach(option => {
                    option.addEventListener('click', deleteMessage);
                });

                // Assuming you have a copy option in your HTML
                document.querySelectorAll('.copy-message').forEach(option => {
                    option.addEventListener('click', copyMessage);
                });


                function scrollToBottom() {
                    var messageWrapper = document.querySelector('.message-wrapper');
                    messageWrapper.scrollTop = messageWrapper.scrollHeight;
                }

                window.onload = scrollToBottom;
            </script>

        </body>

        </html>
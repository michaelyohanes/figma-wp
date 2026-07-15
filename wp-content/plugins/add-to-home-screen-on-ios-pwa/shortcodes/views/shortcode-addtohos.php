<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<a href="#" class="ios-add-to-home-screen-button <?php echo esc_attr($custom_class);?>" style="display: none;">
    <?php echo esc_html($button_text); ?>
</a>

<?php
 wp_enqueue_script( 'addtohos-custom-js', ADDTOHOS_URL . 'public/js/custom-js.js', array( 'jquery' ));


    $addtohos_inline_script = '
    document.addEventListener("DOMContentLoaded", function() {
        let deferredPrompt;
        const installButtons = document.querySelectorAll(".ios-add-to-home-screen-button");

        window.addEventListener("beforeinstallprompt", (event) => {
            event.preventDefault();
            deferredPrompt = event;
            installButtons.forEach(button => button.style.display = "inline-block");
        });

        function isIos() {
            return /iphone|ipad|ipod/i.test(navigator.userAgent);
        }

        function isInStandaloneMode() {
            return window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
        }

        function showInstallMessage() {
            if (document.getElementById("iosAddToHomeScreenPopup")) return; // Prevent duplicate popups

            const popup = document.createElement("div");
            popup.id = "iosAddToHomeScreenPopup";
            popup.innerHTML = `
                      <div id="iosAddToHomeScreenPopup" style="
                    position: fixed;
                    bottom: 20px;
                    left: 0;
                    background:rgb(85, 85, 85);
                    backdrop-filter: blur(10px);
                    padding: 12px 20px;
                    border-radius: 10px;
                    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                    text-align: left;
                    font-size: 14px;
                    width: 100%;
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    line-height: 1.4;
                    gap: 12px;
                    color: #fff;
                    ">
                <span class="icon" style="
                        background: hsl(184.3, 5.8%, 52.9%);
                        border-radius: 4px;
                        padding: 0px;
                    ">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        </span> 
                    <div class="text-message">
                        <?php echo wp_kses_post($popup_text); ?>
                    </div>
                <span style="
                    width: 0;
                    height: 0;
                    border-left: 17px solid transparent;
                    border-right: 17px solid transparent;
                    border-top: 20px solid rgb(85, 85, 85);
                    position: absolute;
                    top: 100%;
                    left: 50%;
                    margin-left: -17px; 
                    ">
                    </span>
                </div>
                `;

            document.body.appendChild(popup);
            setTimeout(() => document.addEventListener("click", () => popup.remove()), 100);
        }

        installButtons.forEach(button => {
            button.addEventListener("click", (e) => {
                e.preventDefault(); 
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(choiceResult => {
                        deferredPrompt = null;
                    });
                } else if (isIos() && !isInStandaloneMode()) {
                    showInstallMessage();
                }
            });

            if (isIos() && !isInStandaloneMode()) {
                button.style.display = "inline-block";
            }
        });

        window.addEventListener("appinstalled", () => console.log("PWA installed"));
    })';
 
    // Add inline script after your main handle
    wp_add_inline_script('addtohos-custom-js', $addtohos_inline_script);
?>